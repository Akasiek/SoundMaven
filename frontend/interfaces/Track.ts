import type { SimpleAlbum } from "~/interfaces/Album";

export interface SimpleTrack {
  id: string;
  title: string;
  slug: string;
  length: string;
  length_in_minutes: string;
  order: string;
  created_at: string;
  updated_at: string;
}

export default interface Track extends SimpleTrack {
  album: SimpleAlbum;
}
