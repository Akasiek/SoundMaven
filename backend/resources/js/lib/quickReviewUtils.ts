import { createGlobalState, useMagicKeys } from "@vueuse/core";
import { Ref, shallowRef } from "vue";
import { InertiaForm } from "@inertiajs/vue3";
import debounce from "lodash.debounce";
import axios from "axios";

const KEYS = { OPEN: 'q', ESCAPE: 'Escape' } as const;

export const useQuickReviewModalOpenState = createGlobalState(() => {
  const isModalOpen = shallowRef<boolean>(false);

  const openModal = () => {
    isModalOpen.value = true;
  }

  const closeModal = () => {
    isModalOpen.value = false;
  }

  const toggleModal = (state?: boolean) => {
    isModalOpen.value = state !== undefined ? state : !isModalOpen.value;
  }

  return { isModalOpen, openModal, closeModal, toggleModal };
});

export const useQuickReviewChosenAlbumState = createGlobalState(() => {
  const chosenAlbum = shallowRef<ExtendedAlbum | null>(null);

  const setChosenAlbum = (album: ExtendedAlbum) => {
    chosenAlbum.value = album;
  }

  const clearChosenAlbum = () => {
    chosenAlbum.value = null;
  }

  return { chosenAlbum, setChosenAlbum, clearChosenAlbum };
});

export const handleGlobalHotkeys = (): void => {
  const { isModalOpen, openModal, closeModal } = useQuickReviewModalOpenState();

  // Handle global key events for opening/closing the modal
  useMagicKeys({
    passive: false,
    onEventFired(e) {
      if (e.key === KEYS.OPEN) {
        handleOpenKey(e);
      } else if (e.key === KEYS.ESCAPE) {
        handleEscapeKey(e);
      }
    }
  });

  const handleOpenKey = (e: KeyboardEvent) => {
    if (!isModalOpen.value) {
      preventDefaultAndStopPropagation(e);
      openModal();
      // form.query = '';
    }
  };

  const handleEscapeKey = (e: KeyboardEvent) => {
    if (isModalOpen.value) {
      preventDefaultAndStopPropagation(e);
      closeModal();
      // form.query = '';
    }
  };

  const preventDefaultAndStopPropagation = (e: KeyboardEvent): void => {
    e.preventDefault();
    e.stopPropagation();
  };
}

export const useSearchSubmit = (
  form: InertiaForm<{ query: string }>,
  queryResults: Ref<{ data: { album: ExtendedAlbum[] } } | null>
): () => void => {
  const { chosenAlbum, setChosenAlbum } = useQuickReviewChosenAlbumState();
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
  }, 200);

  const handleSearchResponse = (response: any) => {
    queryResults.value = response.data;
    form.errors.query = undefined;

    // If an album is already chosen, update it with the latest data from the search results
    if (queryResults.value && chosenAlbum.value) {
      setChosenAlbum(
        queryResults.value.data.album.find((a) => a.id === chosenAlbum.value?.id) || chosenAlbum.value
      );
    }
  };

  return handleSubmit;
}
