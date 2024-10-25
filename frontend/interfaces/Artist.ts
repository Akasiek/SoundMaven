import type { SimpleAlbum } from "~/interfaces/Album";

export interface SimpleArtist {
  id: string; // uuid,
  name: string;
  description: string;
  type: string;
  background_image: string;
  created_at: string;
  updated_at: string;
}

export default interface Artist extends SimpleArtist {
  albums: SimpleAlbum[];
}
