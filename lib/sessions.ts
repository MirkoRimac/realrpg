import { getIronSession, IronSessionData } from "iron-session";
import { cookies } from "next/headers";

export type SessionUser = { userId: string; partyId: string };

declare module "iron-session" {
  interface IronSessionData {
    user?: SessionUser;
  }
}

const sessionOptions = {
  cookieName: "realrpg_session",
  password: process.env.SESSION_SECRET as string,
  cookieOptions: {
    httpOnly: true,
    secure: process.env.NODE_ENV === "production",
    sameSite: "lax" as const,
    path: "/",
  },
};

export async function getSession() {
  return getIronSession<IronSessionData>(await cookies(), sessionOptions);
}
