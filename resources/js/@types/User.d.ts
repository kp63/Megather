export default interface User {
  id: string;
  name: string;
  name_updated_at: string;
  status: string;
  role: string;
}

export interface Profile {
  nickname: string;
  avatar_provider: string;
  avatar_url: string | null;
  bio: string | null;
}
