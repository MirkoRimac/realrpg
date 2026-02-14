import { prisma } from "@/lib/prisma";
import { getSession } from "@/lib/session";

export async function GET() {
  const session = await getSession();
  if (!session.user) return Response.json({ error: "unauthorized" }, { status: 401 });

  const quests = await prisma.quest.findMany({
    where: { partyId: session.user.partyId },
    orderBy: { createdAt: "desc" },
  });

  return Response.json(quests);
}

export async function POST(req: Request) {
  const session = await getSession();
  if (!session.user) return Response.json({ error: "unauthorized" }, { status: 401 });

  const body = await req.json().catch(() => null);
  const title = typeof body?.title === "string" ? body.title.trim() : "";
  if (!title) return Response.json({ error: "title is required" }, { status: 400 });

  const quest = await prisma.quest.create({
    data: {
      title,
      description: typeof body.description === "string" ? body.description.trim() : null,
      startAt: body.startAt ? new Date(body.startAt) : null,
      dueAt: body.dueAt ? new Date(body.dueAt) : null,
      xpReward: Number.isFinite(body.xpReward) ? body.xpReward : undefined,
      goldReward: Number.isFinite(body.goldReward) ? body.goldReward : undefined,
      partyId: session.user.partyId,
    },
  });

  return Response.json(quest, { status: 201 });
}
