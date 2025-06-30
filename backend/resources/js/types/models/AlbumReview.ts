interface AlbumReview {
  id: string, // UUID
  rating: number,
  body: string,
  created_at: string,
  updated_at: string,
}

interface ExtendedAlbumReview extends AlbumReview {
  album: Album,
  creator: User,
}
