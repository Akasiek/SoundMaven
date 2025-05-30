interface Artist {
  id: string; // UUID
  name: string;
  slug: string;
  description: string;
  type: string;
  background_image: string;
  background_image_preview: string;

  created_at: string;
  updated_at: string;
  created_by: string;
  updated_by: string;
}

interface ExtendedArtist extends Artist {
  albums: Album[];
}
