import type { SimpleArtist } from "~/interfaces/Artist";
import type { SimpleTrack } from "~/interfaces/Track";

export interface SimpleAlbum {
  id: string; // uuid
  title: string;
  slug: string;
  description: string;
  release_date: string;
  type: string;
  cover_image: string;
  created_at: string;
  updated_at: string;
}

export default interface Album extends SimpleAlbum {
  artist: SimpleArtist;
  tracks: SimpleTrack[];
}
