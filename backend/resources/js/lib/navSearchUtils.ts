import { InertiaForm } from "@inertiajs/vue3";
import { Ref } from "vue";
import debounce from "lodash.debounce";
import axios from "axios";
import { useMagicKeys } from "@vueuse/core";
import { useQuickReviewModalOpenState } from "@/lib/quickReviewUtils";
import { isUserInputActive, preventDefaultAndStopPropagation } from "@/lib/hotkeyUtils";

const KEYS = { SEARCH: 's' } as const;

export const handleGlobalHotkeys = (): void => {
  const { isOpen: isQuickReviewModalOpen } = useQuickReviewModalOpenState();

  useMagicKeys({
    passive: false,
    onEventFired(e) {
      if (e.key === KEYS.SEARCH) {
        focusSearchInputOnKey(e);
      }
    }
  });

  const focusSearchInputOnKey = (e: KeyboardEvent) => {
    if (isUserInputActive() || isQuickReviewModalOpen.value) {
      return;
    }

    preventDefaultAndStopPropagation(e);
    const searchInput = document.getElementById('nav-search-input') as HTMLInputElement | null;
    if (searchInput) {
      searchInput.focus();
    }
  };
}

export const useSearchSubmit = (form: InertiaForm<{ query: string }>, queryResults: Ref): () => void => {
  const handleSubmit = () => {
    form.query ? debouncedSearch() : (queryResults.value = null);
  };

  const debouncedSearch = debounce(() => {
    axios
      .get(route('search', { query: form.query }))
      .then(handleSearchResponse)
      .catch((err) => {
        queryResults.value = null;
        form.errors.query = err.response.data.message;
      });
  }, 200);

  const handleSearchResponse = (response: any) => {
    queryResults.value = response.data;
    form.errors.query = undefined;
  };

  return handleSubmit;
}
