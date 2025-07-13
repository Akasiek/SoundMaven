interface Album {
  id: string; // UUID
  title: string;
  slug: string;
  description: string;
  release_date: string;
  type: string;
  cover_image: string;
  cover_image_preview: string;
  average_rating: number;
  rating_color: string;
  total_length: number;
  total_length_formatted: string; // in "MM:SS" ("HH:MM:SS" if needed) format

  created_at: string;
  updated_at: string;
  created_by: string;
  updated_by: string;
}

interface ExtendedAlbum extends Album {
  artist: Artist;
  tracks: Track[];
  genres: Genre[];
  reviews: AlbumReview[];
  reviews_count: number;
}
