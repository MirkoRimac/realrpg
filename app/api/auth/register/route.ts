import { prisma } from "@/lib/prisma";
import bcrypt from "bcrypt";
import { getSession } from "@/lib/session";

export async function POST(req: Request) {
  const body = await req.json().catch(() => null);
  const username = typeof body?.username === "string" ? body.username.trim() : "";
  const password = typeof body?.password === "string" ? body.password : "";

  if (username.length < 3) return Response.json({ error: "username too short" }, { status: 400 });
  if (password.length < 6) return Response.json({ error: "password too short" }, { status: 400 });

  const exists = await prisma.user.findUnique({ where: { username } });
  if (exists) return Response.json({ error: "username taken" }, { status: 409 });

  const passwordHash = await bcrypt.hash(password, 12);

  // Standard: registrierter User bekommt direkt eine Party
  const partyName = `${username}'s Party`;

  const user = await prisma.user.create({
    data: {
      username,
      passwordHash,
      party: { create: { name: partyName } },
    },
    include: { party: true },
  });

  const session = await getSession();
  session.user = { userId: user.id, partyId: user.partyId! };
  await session.save();

  return Response.json({ ok: true });
}
