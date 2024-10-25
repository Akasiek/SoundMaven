import type { SimpleAlbum } from "~/interfaces/Album";

export interface SimpleGenre {
  id: string; // uuid
  name: string;
  slug: string;
  description: string;
  created_at: string;
  updated_at: string;
}

export default interface Genre extends SimpleGenre {
  albums: SimpleAlbum[];
}