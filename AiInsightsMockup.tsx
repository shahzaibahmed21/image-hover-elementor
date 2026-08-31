/**
 * AI Insights dashboard mockup — insights list + create-campaign modal on click.
 * Scaled desktop canvas (same pattern as CampaignsMockup / CoPilot tabs).
 */
import { AnimatePresence, motion } from "framer-motion";
import {
  BarChart3,
  Bold,
  Bot,
  ChevronDown,
  CircleHelp,
  Italic,
  LayoutDashboard,
  Link2,
  List,
  ListOrdered,
  LogOut,
  MapPin,
  Megaphone,
  RefreshCw,
  ShoppingBag,
  Sparkles,
  TrendingUp,
  Type,
  Underline,
  Users,
  X,
} from "lucide-react";
import { useEffect, useRef, useState } from "react";

const ORANGE = "#ff5a1f";
const EASE = [0.16, 1, 0.3, 1] as const;
const MOCK_W = 1100;
const MOCK_H = 700;

type Insight = {
  id: string;
  badge: string;
  badgeClass: string;
  dotClass: string;
  ctaClass: string;
  body: string;
  nextAction: string;
  cta: string;
  generated: string;
  campaign: {
    name: string;
    type: string;
    audience: string;
    emailSubject: string;
    emailBody: string;
    sms: string;
  };
};

const INSIGHTS: Insight[] = [
  {
    id: "loyalty",
    badge: "Growth",
    badgeClass: "bg-emerald-50 text-emerald-700",
    dotClass: "bg-emerald-500",
    ctaClass: "bg-emerald-50 text-emerald-700",
    body: "68% of your guests moved into Active or VIP segments this quarter — repeat visits are up 24% and average order value climbed 12%.",
    nextAction: "Reward momentum with a VIP appreciation offer to keep high-value guests ordering weekly.",
    cta: "Launch VIP rewards campaign",
    generated: "Generated: Aug 10, 2025, 5:53 PM",
    campaign: {
      name: "VIP appreciation rewards — thank your top guests",
      type: "Loyalty boost",
      audience: "VIP only",
      emailSubject: "A thank-you from us — exclusive VIP perk inside",
      emailBody:
        "Celebrate your best guests with a clear loyalty progression (Active → VIP → Ambassador). Send automated email and SMS when guests hit visit milestones so momentum keeps building.",
      sms: "You're one of our VIPs! Enjoy 15% off your next order this week. Thanks for ordering direct — we saved your usual for 1-tap reorder.",
    },
  },
  {
    id: "vip",
    badge: "Action ready",
    badgeClass: "bg-orange-50 text-orange-700",
    dotClass: "bg-orange-500",
    ctaClass: "bg-orange-50 text-orange-700",
    body: "312 VIP customers now order weekly — up 31% since last month. Direct online sales from this segment grew $18,400 in the last 30 days.",
    nextAction: "Send a personalized thank-you campaign to reinforce the habit and lift basket size.",
    cta: "Send loyalty boost campaign",
    generated: "Generated: Aug 10, 2025, 5:53 PM",
    campaign: {
      name: "Weekly VIP thank-you — grow basket size",
      type: "Retention",
      audience: "VIP only",
      emailSubject: "Your usual is ready — plus a little thank-you",
      emailBody:
        "Trigger a friendly check-in when VIP guests hit their second weekly order. Highlight favorites, suggest an add-on, and remind them of rewards progress — all from your branded ordering site.",
      sms: "Thanks for another order this week! Add a side for 10% off today only. Your rewards progress: 8/10 stamps.",
    },
  },
  {
    id: "active",
    badge: "Opportunity",
    badgeClass: "bg-sky-50 text-sky-700",
    dotClass: "bg-sky-500",
    ctaClass: "bg-sky-50 text-sky-700",
    body: "Your Active segment grew 42% — guests visiting 2+ times per month now drive 61% of direct revenue. Occasional guests are converting faster than ever.",
    nextAction: "Automate milestone rewards to move Occasional guests into Active before their next visit window closes.",
    cta: "Create milestone campaign",
    generated: "Generated: Aug 10, 2025, 5:53 PM",
    campaign: {
      name: "Active guest milestone rewards — 2 visits in 14 days",
      type: "Win-back",
      audience: "Occasional guests",
      emailSubject: "You're close to Active status — here's a boost",
      emailBody:
        "Design dining-frequency incentives with a clear path (Occasional → Active → VIP). Launch automated email/SMS when guests are one visit away from the next tier so momentum keeps climbing.",
      sms: "One more visit this week unlocks Active rewards — 10% off your next order when you order direct. Tap to reorder in 1 click.",
    },
  },
];

const NAV = [
  {
    section: "OVERVIEW",
    items: [
      { label: "Dashboard", icon: LayoutDashboard },
      { label: "AI insights", icon: Sparkles, active: true, badge: 3 },
      { label: "AI Bot", icon: Bot },
    ],
  },
  {
    section: "CUSTOMERS & CRM",
    items: [
      { label: "All customers", icon: Users },
      { label: "Loyalty program", icon: TrendingUp },
      { label: "Segments", icon: Users },
    ],
  },
  {
    section: "ORDERS & MENU",
    items: [
      { label: "Orders", icon: ShoppingBag },
      { label: "Menu performance", icon: BarChart3 },
    ],
  },
  {
    section: "MARKETING",
    items: [{ label: "Campaigns", icon: Megaphone }],
  },
  {
    section: "ANALYTICS",
    items: [
      { label: "Reports", icon: BarChart3 },
      { label: "MOM report view", icon: TrendingUp },
    ],
  },
] as const;

function Sidebar() {
  return (
    <aside className="flex h-full w-[228px] shrink-0 flex-col border-r border-slate-200 bg-white">
      <div className="flex items-center px-3 pb-3 pt-4">
        <img src="/images/logo.svg" alt="GrabEasy" className="h-7 w-auto max-w-[150px] object-contain object-left" draggable={false} />
      </div>

      <nav className="flex-1 overflow-y-auto px-2.5 pb-3">
        {NAV.map((group) => (
          <div key={group.section} className="mt-2 first:mt-0.5">
            <p className="px-2.5 text-[9px] font-bold uppercase tracking-[0.14em] text-slate-400">{group.section}</p>
            <ul className="mt-0.5 space-y-0.5">
              {group.items.map((item) => {
                const Icon = item.icon;
                const active = "active" in item && item.active;
                return (
                  <li key={item.label}>
                    <button
                      type="button"
                      className={`relative flex w-full items-center gap-2 rounded-lg px-2 py-1.5 text-left text-[12px] font-semibold transition-colors ${
                        active ? "bg-[#fff1e8] text-[#ff5a1f]" : "text-slate-600 hover:bg-slate-50"
                      }`}
                    >
                      {active && <span className="absolute bottom-1.5 left-0 top-1.5 w-[3px] rounded-r-full bg-[#ff5a1f]" />}
                      <Icon className={`h-4 w-4 shrink-0 ${active ? "text-[#ff5a1f]" : "text-slate-400"}`} />
                      <span className="min-w-0 flex-1 truncate">{item.label}</span>
                      {"badge" in item && item.badge != null && (
                        <span className="rounded-full bg-[#ff5a1f] px-1.5 py-0.5 text-[10px] font-extrabold leading-none text-white">
                          {item.badge}
                        </span>
                      )}
                    </button>
                  </li>
                );
              })}
            </ul>
          </div>
        ))}
      </nav>

      <div className="border-t border-slate-200 p-2.5">
        <div className="flex items-center gap-2.5 rounded-xl px-2 py-2">
          <span className="grid h-9 w-9 shrink-0 place-items-center rounded-full text-sm font-extrabold text-white" style={{ background: ORANGE }}>
            A
          </span>
          <div className="min-w-0">
            <p className="truncate text-[13px] font-bold text-slate-800">admin</p>
            <p className="truncate text-[11px] text-slate-400">admin@grabeasy.com</p>
          </div>
        </div>
        <button type="button" className="mt-1 flex w-full items-center gap-2 rounded-xl px-2.5 py-2 text-[13px] font-semibold text-slate-500 hover:bg-slate-50">
          <LogOut className="h-4 w-4" />
          Log out
        </button>
      </div>
    </aside>
  );
}

function SummaryCard({ label, value, valueClass, sub }: { label: string; value: string; valueClass: string; sub: string }) {
  return (
    <div className="rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-[0_1px_2px_rgba(15,23,42,0.04)]">
      <div className="flex items-center gap-1.5 text-[12px] font-medium text-slate-500">
        {label}
        <CircleHelp className="h-3.5 w-3.5 text-slate-300" />
      </div>
      <p className={`mt-1 text-[2rem] font-extrabold leading-none tracking-tight ${valueClass}`}>{value}</p>
      <p className="mt-1 text-[11px] font-medium text-slate-400">{sub}</p>
    </div>
  );
}

function InsightCard({ insight, onOpen }: { insight: Insight; onOpen: () => void }) {
  return (
    <button
      type="button"
      onClick={onOpen}
      className="w-full rounded-xl border border-slate-200 bg-white p-4 text-left shadow-[0_1px_2px_rgba(15,23,42,0.04)] transition-[box-shadow,border-color] duration-200 hover:border-slate-300 hover:shadow-[0_12px_32px_-20px_rgba(15,23,42,0.16)]"
    >
      <div className="flex items-start justify-between gap-3">
        <div className="flex min-w-0 flex-1 items-start gap-2">
          <span className={`mt-1.5 h-2 w-2 shrink-0 rounded-full ${insight.dotClass}`} />
          <div className="min-w-0">
            <p className="text-[13px] font-semibold leading-snug text-slate-800">{insight.body}</p>
            <p className="mt-2 text-[12px] leading-relaxed text-slate-500">
              <span className="font-bold text-slate-700">Next action:</span> {insight.nextAction}
            </p>
            <p className="mt-2 text-[10px] text-slate-400">{insight.generated}</p>
            <span className={`mt-3 inline-flex rounded-lg px-3 py-1.5 text-[11px] font-bold ${insight.ctaClass}`}>{insight.cta}</span>
          </div>
        </div>
        <div className="flex shrink-0 flex-col items-end gap-2">
          <span className={`rounded-full px-2.5 py-1 text-[10px] font-bold ${insight.badgeClass}`}>{insight.badge}</span>
          <div className="flex items-center gap-1.5 text-[10px] text-slate-400">
            <MapPin className="h-3 w-3" />
            All locations
            <span
              role="presentation"
              onClick={(e) => e.stopPropagation()}
              className="grid h-5 w-5 place-items-center rounded text-slate-400"
            >
              <X className="h-3 w-3" />
            </span>
          </div>
        </div>
      </div>
    </button>
  );
}

function RichToolbar() {
  const tools = [
    { icon: Bold, label: "Bold" },
    { icon: Italic, label: "Italic" },
    { icon: Underline, label: "Underline" },
    { icon: List, label: "Bullets" },
    { icon: ListOrdered, label: "Numbered" },
    { icon: Link2, label: "Link" },
    { icon: Type, label: "Clear" },
  ];
  return (
    <div className="flex flex-wrap items-center gap-0.5 border-b border-slate-100 px-2 py-1.5">
      {tools.map(({ icon: Icon, label }) => (
        <button key={label} type="button" aria-label={label} className="grid h-7 w-7 place-items-center rounded text-slate-500">
          <Icon className="h-3.5 w-3.5" />
        </button>
      ))}
    </div>
  );
}

function CreateCampaignModal({ insight, onClose }: { insight: Insight; onClose: () => void }) {
  const c = insight.campaign;
  return (
    <>
      <motion.button
        type="button"
        aria-label="Close"
        initial={{ opacity: 0 }}
        animate={{ opacity: 1 }}
        exit={{ opacity: 0 }}
        transition={{ duration: 0.2 }}
        onClick={onClose}
        className="absolute inset-0 z-20 bg-slate-900/45"
      />
      <motion.div
        role="dialog"
        aria-modal
        initial={{ opacity: 0, y: 14 }}
        animate={{ opacity: 1, y: 0 }}
        exit={{ opacity: 0, y: 10 }}
        transition={{ duration: 0.35, ease: EASE }}
        className="absolute inset-x-6 top-6 z-30 mx-auto flex max-h-[calc(100%-3rem)] max-w-[720px] flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-[0_30px_80px_-24px_rgba(15,23,42,0.35)]"
      >
        <div className="flex shrink-0 items-center justify-between border-b border-slate-100 px-5 py-3.5">
          <h2 className="text-[15px] font-extrabold text-slate-900">Create new campaign</h2>
          <button type="button" onClick={onClose} className="grid h-8 w-8 place-items-center rounded-lg text-slate-400 hover:bg-slate-100">
            <X className="h-4 w-4" />
          </button>
        </div>

        <div className="min-h-0 flex-1 space-y-3 overflow-y-auto px-5 py-4">
          <label className="block">
            <span className="text-[12px] font-semibold text-slate-700">
              Campaign name <span className="text-red-500">*</span>
            </span>
            <input readOnly value={c.name} className="mt-1 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-[12px] font-medium text-slate-800 outline-none" />
          </label>

          <div className="grid grid-cols-2 gap-3">
            <label className="block">
              <span className="inline-flex items-center gap-1 text-[12px] font-semibold text-slate-700">
                Campaign type <CircleHelp className="h-3 w-3 text-slate-300" />
              </span>
              <div className="relative mt-1">
                <select defaultValue={c.type} className="w-full appearance-none rounded-lg border border-slate-200 bg-white px-3 py-2 pr-8 text-[12px] font-medium text-slate-800 outline-none">
                  <option>{c.type}</option>
                </select>
                <ChevronDown className="pointer-events-none absolute right-2.5 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-slate-400" />
              </div>
            </label>
            <label className="block">
              <span className="inline-flex items-center gap-1 text-[12px] font-semibold text-slate-700">
                Target audience <CircleHelp className="h-3 w-3 text-slate-300" />
              </span>
              <div className="relative mt-1">
                <select defaultValue={c.audience} className="w-full appearance-none rounded-lg border border-slate-200 bg-white px-3 py-2 pr-8 text-[12px] font-medium text-slate-800 outline-none">
                  <option>{c.audience}</option>
                </select>
                <ChevronDown className="pointer-events-none absolute right-2.5 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-slate-400" />
              </div>
            </label>
          </div>

          <div>
            <p className="text-[12px] font-semibold text-slate-700">Channel</p>
            <div className="mt-2 flex flex-wrap gap-4">
              {[
                { label: "EMAIL", checked: true },
                { label: "SMS", checked: true },
                { label: "Push Notification", checked: false },
              ].map((ch) => (
                <span key={ch.label} className="inline-flex items-center gap-2 text-[11px] font-bold tracking-wide text-slate-600">
                  <span className={`grid h-4 w-4 place-items-center rounded border text-[10px] ${ch.checked ? "border-[#ff5a1f] bg-[#ff5a1f] text-white" : "border-slate-300 bg-white"}`}>
                    {ch.checked ? "✓" : ""}
                  </span>
                  {ch.label}
                </span>
              ))}
            </div>
          </div>

          <label className="block">
            <span className="text-[12px] font-semibold text-slate-700">Email subject</span>
            <input readOnly value={c.emailSubject} className="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-[12px] text-slate-800 outline-none" />
          </label>

          <div>
            <p className="text-[12px] font-semibold text-slate-700">Email body</p>
            <div className="mt-1 overflow-hidden rounded-lg border border-slate-200">
              <RichToolbar />
              <textarea readOnly value={c.emailBody} rows={4} className="w-full resize-none px-3 py-2 text-[12px] leading-relaxed text-slate-700 outline-none" />
            </div>
          </div>

          <div>
            <p className="text-[12px] font-semibold text-slate-700">SMS message</p>
            <div className="relative mt-1">
              <textarea readOnly value={c.sms} rows={3} className="w-full resize-none rounded-lg border border-slate-200 px-3 py-2 text-[12px] leading-relaxed text-slate-700 outline-none" />
              <span className="absolute bottom-2 right-2 text-[10px] font-medium text-slate-400">{c.sms.length} chars</span>
            </div>
          </div>

          <label className="block">
            <span className="text-[12px] font-semibold text-slate-700">Schedule</span>
            <div className="relative mt-1">
              <select className="w-full appearance-none rounded-lg border border-slate-200 bg-white px-3 py-2 pr-8 text-[12px] font-medium text-slate-800 outline-none">
                <option>Send immediately</option>
              </select>
              <ChevronDown className="pointer-events-none absolute right-2.5 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-slate-400" />
            </div>
          </label>
        </div>

        <div className="flex shrink-0 items-center justify-end gap-2 border-t border-slate-100 px-5 py-3.5">
          <button type="button" onClick={onClose} className="rounded-lg border border-slate-200 px-4 py-2 text-[12px] font-bold text-slate-600 hover:bg-slate-50">
            Cancel
          </button>
          <button type="button" onClick={onClose} className="rounded-lg px-4 py-2 text-[12px] font-bold text-white" style={{ background: ORANGE }}>
            Create campaign
          </button>
        </div>
      </motion.div>
    </>
  );
}

function AiInsightsInner() {
  const [selected, setSelected] = useState<Insight | null>(null);

  return (
    <div className="relative flex h-full w-full overflow-hidden bg-[#f6f7f9]">
      <Sidebar />

      <div className="flex min-w-0 flex-1 flex-col overflow-hidden">
        <div className="shrink-0 border-b border-slate-200/80 bg-white px-5 py-3">
          <div className="flex items-center justify-between gap-3">
            <h1 className="inline-flex items-center gap-1.5 text-lg font-extrabold tracking-tight text-slate-900">
              AI insights
              <CircleHelp className="h-4 w-4 text-slate-300" />
            </h1>
            <div className="flex items-center gap-2">
              <button type="button" className="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-[11px] font-semibold text-slate-600">
                <MapPin className="h-3.5 w-3.5 text-slate-400" />
                All locations
                <ChevronDown className="h-3.5 w-3.5 text-slate-400" />
              </button>
              <button type="button" className="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-[11px] font-semibold text-slate-600">
                <RefreshCw className="h-3.5 w-3.5 text-slate-400" />
                Refresh insights
              </button>
            </div>
          </div>
        </div>

        <div className="min-h-0 flex-1 space-y-3 overflow-y-auto p-4">
          <div className="grid grid-cols-2 gap-3">
            <SummaryCard label="Actionable insights" value="3" valueClass="text-[#ff5a1f]" sub="1,597 customers analyzed" />
            <SummaryCard label="Growing regulars" value="1,248" valueClass="text-emerald-600" sub="+22% active & VIP guests vs last month" />
          </div>

          <div className="space-y-2.5">
            {INSIGHTS.map((insight, i) => (
              <motion.div
                key={insight.id}
                initial={{ opacity: 0, y: 8 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: 0.06 + i * 0.05, duration: 0.4, ease: EASE }}
              >
                <InsightCard insight={insight} onOpen={() => setSelected(insight)} />
              </motion.div>
            ))}
          </div>
        </div>
      </div>

      <AnimatePresence>
        {selected && <CreateCampaignModal key={selected.id} insight={selected} onClose={() => setSelected(null)} />}
      </AnimatePresence>
    </div>
  );
}

export default function AiInsightsMockup() {
  const wrapRef = useRef<HTMLDivElement>(null);
  const [scale, setScale] = useState(1);

  useEffect(() => {
    const el = wrapRef.current;
    if (!el) return;

    const update = () => {
      const width = el.getBoundingClientRect().width;
      setScale(Math.max(0.28, Math.min(1, width / MOCK_W)));
    };

    update();
    const obs = new ResizeObserver(update);
    obs.observe(el);
    window.addEventListener("resize", update);

    return () => {
      obs.disconnect();
      window.removeEventListener("resize", update);
    };
  }, []);

  return (
    <div
      ref={wrapRef}
      className="relative w-full overflow-hidden rounded-2xl border border-espresso/10 bg-white shadow-2xl shadow-espresso/10 sm:rounded-3xl"
      style={{ height: MOCK_H * scale }}
    >
      <div
        style={{
          width: MOCK_W,
          height: MOCK_H,
          transform: `scale(${scale})`,
          transformOrigin: "top left",
        }}
      >
        <AiInsightsInner />
      </div>
    </div>
  );
}
