import { prisma } from "@/lib/prisma";

export async function GET() {
  const quests = await prisma.quest.findMany({
    orderBy: { createdAt: "desc" },
  });

  return Response.json(quests);
}

export async function POST(req: Request) {
  const body = await req.json().catch(() => null);

  if (!body || typeof body.title !== "string" || body.title.trim().length === 0) {
    return Response.json({ error: "title is required" }, { status: 400 });
  }

  const quest = await prisma.quest.create({
    data: {
      title: body.title.trim(),
      description: typeof body.description === "string" ? body.description.trim() : null,
      startAt: body.startAt ? new Date(body.startAt) : null,
      dueAt: body.dueAt ? new Date(body.dueAt) : null,
      xpReward: Number.isFinite(body.xpReward) ? body.xpReward : undefined,
      goldReward: Number.isFinite(body.goldReward) ? body.goldReward : undefined,
    },
  });

  return Response.json(quest, { status: 201 });
}
