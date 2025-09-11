import { type ClassValue, clsx } from 'clsx'
import { twMerge } from 'tailwind-merge'
import { createGlobalState } from "@vueuse/core";
import { shallowRef } from "vue";

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs))
}

export const createToggleState = () => createGlobalState(() => {
  const isOpen = shallowRef<boolean>(false);

  const open = () => {
    isOpen.value = true;
  }

  const close = () => {
    isOpen.value = false;
  }

  const toggle = () => {
    isOpen.value = !isOpen.value;
  }

  return { isOpen, open, close, toggle };
});

