import { useStorage } from "@vueuse/core";
import { computed } from "vue";

export function useComputedStorage<T = string>(
  storageKey: string,
  defaultValue: T | null = null
) {
  const storageValue = useStorage(storageKey, defaultValue);

  return computed({
    get: () => storageValue.value as T,
    set: (newValue: T) => {
      storageValue.value = newValue;
    }
  });
}
