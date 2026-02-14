import { cookies } from "next/headers";
import { redirect } from "next/navigation";
import { prisma } from "@/lib/prisma";
import { getSession } from "@/lib/sessions";


type Quest = {
  id: string;
  title: string;
  description: string | null;
  xpReward: number;
  goldReward: number;
  status: "OPEN" | "COMPLETED";
  createdAt: string;
};

async function getQuests(): Promise<Quest[]> {
  const session = await getSession();
  if (!session.user) redirect("/login");

  const quests = await prisma.quest.findMany({
    where: { partyId: session.user.partyId },
    orderBy: { createdAt: "desc" },
  });

  // Prisma Date -> string für React
  return quests.map((q) => ({
    ...q,
    createdAt: q.createdAt.toISOString(),
  })) as Quest[];
}



export default async function QuestsPage() {
  const quests = await getQuests();

async function createQuest(formData: FormData) {
    "use server";

    const title = String(formData.get("title") ?? "").trim();
    const description = String(formData.get("description") ?? "").trim();

    if (!title) return;

    const session = await getSession();
    if (!session.user) redirect("/login");

    await prisma.quest.create({
      data: {
        title,
        description: description.length ? description : null,
        partyId: session.user.partyId,
      },
    });

    redirect("/quests");
  }



  return (
    <main style={{ padding: 24, maxWidth: 800, margin: "0 auto" }}>
      <h1 style={{ fontSize: 28, fontWeight: 700 }}>Quests</h1>

      <section style={{ marginTop: 16, padding: 16, border: "1px solid #ddd", borderRadius: 8 }}>
        <h2 style={{ fontSize: 18, fontWeight: 600 }}>Create Quest</h2>

        <form action={createQuest} style={{ display: "grid", gap: 10, marginTop: 12 }}>
          <input
            name="title"
            placeholder="Title"
            required
            style={{ padding: 10, border: "1px solid #ccc", borderRadius: 6 }}
          />
          <textarea
            name="description"
            placeholder="Description (optional)"
            style={{ padding: 10, border: "1px solid #ccc", borderRadius: 6, minHeight: 90 }}
          />
          <button type="submit" style={{ padding: 10, borderRadius: 6, border: "1px solid #ccc" }}>
            Create
          </button>
        </form>
      </section>

      <section style={{ marginTop: 18 }}>
        <h2 style={{ fontSize: 18, fontWeight: 600 }}>Latest</h2>
        <ul style={{ marginTop: 10, display: "grid", gap: 10, padding: 0, listStyle: "none" }}>
          {quests.map((q) => (
            <li key={q.id} style={{ padding: 12, border: "1px solid #eee", borderRadius: 8 }}>
              <div style={{ display: "flex", justifyContent: "space-between", gap: 12 }}>
                <div>
                  <div style={{ fontWeight: 700 }}>{q.title}</div>
                  {q.description && <div style={{ marginTop: 6, opacity: 0.8 }}>{q.description}</div>}
                </div>
                <div style={{ textAlign: "right", whiteSpace: "nowrap" }}>
                  <div>XP: {q.xpReward}</div>
                  <div>Gold: {q.goldReward}</div>
                </div>
              </div>
              <div style={{ marginTop: 8, fontSize: 12, opacity: 0.65 }}>
                {new Date(q.createdAt).toLocaleString()}
              </div>
            </li>
          ))}
          {quests.length === 0 && <li style={{ opacity: 0.7 }}>No quests yet.</li>}
        </ul>
      </section>
    </main>
  );
}
