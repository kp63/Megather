import User from "./User";

declare global {
  interface Window {
    app: { [key: string]: any } | undefined;
    user: User | undefined;
    __: { [key: string]: string } | undefined
  }
}
