// Prevent the first key being sent to input
export const preventDefaultAndStopPropagation = (e: KeyboardEvent): void => {
  e.preventDefault();
  e.stopPropagation();
};

// Check if the user is currently focused on an input, textarea, or contenteditable element
export const isUserInputActive = (): boolean => {
  const activeElement = document.activeElement;
  const tags = ['INPUT', 'TEXTAREA'];
  return !!activeElement && (tags.includes(activeElement.tagName) || (activeElement as HTMLElement).isContentEditable);
}
