interface Track {
    id: string;
    title: string;
    slug: string;
    length: number; // in seconds
    length_in_minutes: number; // in minutes
    order: number;
    created_at: string;
    updated_at: string;
    created_by: string;
    updated_by: string;
}

interface ExtendedTrack extends Track {
    album: Album;
}
