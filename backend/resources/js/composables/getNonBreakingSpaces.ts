import { computed } from "vue";

export function getNonBreakingSpacesAsRef(text: String) {
  return computed(() => text.replace(/&nbsp;/g, '\u00A0'));
}

export function getNonBreakingSpaces(text: String) {
  return text.replace(/&nbsp;/g, '\u00A0');
}
