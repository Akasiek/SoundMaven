import { useMagicKeys } from "@vueuse/core";
import { Ref } from "vue";
import { InertiaForm } from "@inertiajs/vue3";
import debounce from "lodash.debounce";
import axios from "axios";

const KEYS = { SEARCH: 'q', ESCAPE: 'Escape' } as const;

export const handleGlobalHotkeys = (showModal: Ref<boolean>, form: InertiaForm<{ query: string }>): void => {
  // Handle global key events for opening/closing the modal
  useMagicKeys({
    passive: false,
    onEventFired(e) {
      if (e.key === KEYS.SEARCH) {
        handleSearchKey(e);
      } else if (e.key === KEYS.ESCAPE) {
        handleEscapeKey(e);
      }
    }
  });

  const handleSearchKey = (e: KeyboardEvent) => {
    if (!showModal.value) {
      preventDefaultAndStopPropagation(e);
      showModal.value = true;
      form.query = '';
    }
  };

  const handleEscapeKey = (e: KeyboardEvent) => {
    if (showModal.value) {
      preventDefaultAndStopPropagation(e);
      showModal.value = false;
      form.query = '';
    }
  };

  const preventDefaultAndStopPropagation = (e: KeyboardEvent): void => {
    e.preventDefault();
    e.stopPropagation();
  };
}

export const useSearchSubmit = (
  form: InertiaForm<{ query: string }>,
  queryResults: Ref<{ data: { album: ExtendedAlbum[] } } | null>,
  chosenAlbum: Ref<ExtendedAlbum | null>
): () => void => {
  const handleSubmit = () => {
    form.query ? debouncedSearch() : (queryResults.value = null);
  };

  const debouncedSearch = debounce(() => {
    axios
      .get(route('search', { type: 'album', query: form.query }))
      .then(handleSearchResponse)
      .catch((err) => {
        queryResults.value = null;
        form.errors.query = err.response.data.message;
      });
  }, 100);

  const handleSearchResponse = (response: any) => {
    queryResults.value = response.data;
    form.errors.query = undefined;

    // If an album is already chosen, update it with the latest data from the search results
    if (queryResults.value && chosenAlbum.value) {
      chosenAlbum.value = queryResults.value.data.album.find((a) => a.id === chosenAlbum.value?.id) || chosenAlbum.value;
    }
  };

  return handleSubmit;
}
