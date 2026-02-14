import { prisma } from "@/lib/prisma";
import bcrypt from "bcrypt";
import { getSession } from "@/lib/sessions";

export async function POST(req: Request) {
  const body = await req.json().catch(() => null);

  const username = typeof body?.username === "string" ? body.username.trim() : "";
  const password = typeof body?.password === "string" ? body.password : "";

  const user = await prisma.user.findUnique({ where: { username } });
  if (!user) return Response.json({ error: "invalid credentials" }, { status: 401 });

  const ok = await bcrypt.compare(password, user.passwordHash);
  if (!ok) return Response.json({ error: "invalid credentials" }, { status: 401 });

  const session = await getSession();
  session.user = { userId: user.id, partyId: user.partyId! };
  await session.save();

  return Response.json({ ok: true });
}
