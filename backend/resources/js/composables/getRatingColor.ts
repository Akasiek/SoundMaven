export const getRatingColor = (rating: string | number): 'zinc'|'red'|'yellow'|'green' => {
  const numRating = typeof rating === 'number' ? rating : parseInt(rating, 10);
  if (rating === '' || Number.isNaN(numRating)) return 'zinc';

  if (numRating < 30) return 'red';
  else if (numRating < 70) return 'yellow';
  else return 'green';
}
