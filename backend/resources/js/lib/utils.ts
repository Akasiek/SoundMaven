import { type ClassValue, clsx } from 'clsx'
import { twMerge } from 'tailwind-merge'
import { createGlobalState } from "@vueuse/core";
import { shallowRef } from "vue";

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs))
}

export const createModalState = () => createGlobalState(() => {
  const isModalOpen = shallowRef<boolean>(false);

  const openModal = () => {
    isModalOpen.value = true;
  }

  const closeModal = () => {
    isModalOpen.value = false;
  }

  const toggleModal = () => {
    isModalOpen.value = !isModalOpen.value;
  }

  return { isModalOpen, openModal, closeModal, toggleModal };
});
