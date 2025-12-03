interface User {
  id: number;
  name: string;
  email: string;
  slug: string;
  avatar: string | null;
  avatar_preview: string | null;
  favorite_artist: Artist | null;
}

interface UserWithStats extends User {
  stats: {
    album_rating_count: number;
    album_review_count: number;
    average_album_rating: number;
  }
}
