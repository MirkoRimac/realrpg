import { redirect } from "next/navigation";
import { prisma } from "@/lib/prisma";
import { getSession } from "@/lib/sessions";

export default async function WalletPage() {
  const session = await getSession();
  if (!session.user) redirect("/login");

  const user = await prisma.user.findUnique({
    where: { id: session.user.userId },
    select: { username: true, xp: true, gold: true },
  });

  const transactions = await prisma.walletTransaction.findMany({
    where: {
      userId: session.user.userId,
    },
    orderBy: { createdAt: "desc" },
    take: 20,
  });

  return (
    <main style={{ padding: 24, maxWidth: 800, margin: "0 auto" }}>
      <h1 style={{ fontSize: 28, fontWeight: 700 }}>Wallet</h1>

      <section style={{ marginTop: 20, padding: 16, border: "1px solid #ddd", borderRadius: 8 }}>
        <div style={{ fontSize: 18, fontWeight: 600 }}>
          {user?.username ?? "User"}
        </div>
        <div style={{ marginTop: 8 }}>
          <strong>XP:</strong> {user?.xp ?? 0}
        </div>
        <div>
          <strong>Gold:</strong> {user?.gold ?? 0}
        </div>
      </section>

      <section style={{ marginTop: 24 }}>
        <h2 style={{ fontSize: 18, fontWeight: 600 }}>Recent Transactions</h2>

        <ul style={{ marginTop: 12, display: "grid", gap: 10, padding: 0, listStyle: "none" }}>
          {transactions.map((tx) => (
            <li key={tx.id} style={{ padding: 12, border: "1px solid #eee", borderRadius: 8 }}>
              <div style={{ display: "flex", justifyContent: "space-between" }}>
                <div>
                  <div style={{ fontWeight: 600 }}>{tx.type}</div>
                  {tx.note && (
                    <div style={{ fontSize: 12, opacity: 0.7 }}>{tx.note}</div>
                  )}
                </div>

                <div style={{ textAlign: "right" }}>
                  <div>XP: {tx.xpChange >= 0 ? "+" : ""}{tx.xpChange}</div>
                  <div>Gold: {tx.goldChange >= 0 ? "+" : ""}{tx.goldChange}</div>
                </div>
              </div>

              <div style={{ marginTop: 6, fontSize: 12, opacity: 0.6 }}>
                {new Date(tx.createdAt).toLocaleString()}
              </div>
            </li>
          ))}

          {transactions.length === 0 && (
            <li style={{ opacity: 0.7 }}>No transactions yet.</li>
          )}
        </ul>
      </section>
    </main>
  );
}
