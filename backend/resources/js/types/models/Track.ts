interface Track {
  id: string;
  title: string;
  slug: string;
  length: number;
  length_in_minutes: string; // in "MM:SS" ("HH:MM:SS" if needed) format
  order: number;
  disc: number;

  created_at: string;
  updated_at: string;
  created_by: string;
  updated_by: string;
}

interface ExtendedTrack extends Track {
  album: Album;
}
