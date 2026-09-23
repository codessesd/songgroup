<script setup lang="ts">
  import { Head, Link } from "@inertiajs/vue3";
  import { ArrowUpRight, CalendarDays, Check, ChevronRight, Circle, Clock3, ListMusic, Plus, Users } from "@lucide/vue";

  const songs = [
    { title: "Come Thou Fount", artist: "Robert Robinson", key: "G", status: "Ready", accent: "bg-rose-500" },
    { title: "Goodness of God", artist: "Bethel Music", key: "C", status: "Needs notes", accent: "bg-amber-400" },
    { title: "Build My Life", artist: "Housefires", key: "D", status: "Ready", accent: "bg-teal-400" },
    { title: "Great Are You Lord", artist: "All Sons & Daughters", key: "A", status: "Ready", accent: "bg-sky-400" },
  ];

  const serviceDetails = [
    { label: "Service", value: "Sunday morning" },
    { label: "Date", value: "October 12, 2025" },
    { label: "Team", value: "Worship · 6 members" },
  ];
</script>

<template>
  <Head title="Home" />

  <main class="min-h-[calc(100vh-73px)] bg-[#f6f4ef] text-[#17211f]">
    <div class="mx-auto max-w-7xl px-5 py-10 sm:px-8 lg:px-10 lg:py-14">
      <section
        class="relative overflow-hidden rounded-[2rem] bg-[#173d3a] px-6 py-8 text-[#f7f3e9] shadow-[0_24px_60px_-28px_rgba(23,61,58,0.6)] sm:px-10 sm:py-10 lg:px-14 lg:py-12"
      >
        <div class="absolute -right-20 -top-24 h-72 w-72 rounded-full border-[34px] border-[#e5a379]/25" />
        <div class="absolute -bottom-24 right-28 h-48 w-48 rounded-full border-[22px] border-[#88b8ae]/20" />
        <div class="relative max-w-3xl">
          <p class="mb-5 flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.22em] text-[#e7b08c]">
            <span class="h-2 w-2 rounded-full bg-[#e7b08c]" /> Sunday, October 12
          </p>
          <h1 class="max-w-2xl text-4xl font-semibold leading-[1.05] tracking-tight sm:text-6xl">
            Make every Sunday feel prepared.
          </h1>
          <p class="mt-5 max-w-xl text-base leading-7 text-[#c6d5ce] sm:text-lg">
            SongGroup keeps your worship team aligned, from the first song choice to the final downbeat.
          </p>
          <div class="mt-8 flex flex-wrap gap-3">
            <button
              class="inline-flex items-center gap-2 rounded-full bg-[#e7b08c] px-5 py-3 text-sm font-semibold text-[#173d3a] transition hover:bg-[#f1c09f]"
            >
              <Plus class="h-4 w-4" /> Create a setlist
            </button>
            <button
              class="inline-flex items-center gap-2 rounded-full border border-[#c6d5ce]/30 px-5 py-3 text-sm font-semibold text-[#f7f3e9] transition hover:bg-white/10"
            >
              <CalendarDays class="h-4 w-4" /> View calendar
            </button>
          </div>
        </div>
        <div class="relative mt-10 grid max-w-3xl grid-cols-2 gap-x-6 gap-y-5 border-t border-white/15 pt-6 sm:grid-cols-3">
          <div v-for="detail in serviceDetails" :key="detail.label">
            <p class="text-xs uppercase tracking-[0.16em] text-[#8fb5aa]">{{ detail.label }}</p>
            <p class="mt-1 text-sm font-medium text-[#f7f3e9]">{{ detail.value }}</p>
          </div>
        </div>
      </section>

      <section class="mt-10 grid gap-6 lg:grid-cols-[1.4fr_0.8fr]">
        <div>
          <div class="mb-4 flex items-end justify-between">
            <div>
              <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#b56e4b]">Your workspace</p>
              <h2 class="mt-2 text-2xl font-semibold tracking-tight">This Sunday’s setlist</h2>
            </div>
            <button class="hidden items-center gap-1 text-sm font-semibold text-[#39766b] hover:text-[#173d3a] sm:flex">
              Open setlist <ArrowUpRight class="h-4 w-4" />
            </button>
          </div>
          <div class="overflow-hidden rounded-2xl border border-[#dcd8ce] bg-[#fffdf8]">
            <div class="flex items-center justify-between border-b border-[#e9e5db] px-5 py-4 sm:px-6">
              <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#f2dfd1] text-[#b56e4b]">
                  <ListMusic class="h-5 w-5" />
                </div>
                <div>
                  <p class="font-semibold">Morning Worship</p>
                  <p class="text-xs text-[#78817c]">4 songs · 24 minutes</p>
                </div>
              </div>
              <span class="rounded-full bg-[#e4f0e9] px-3 py-1 text-xs font-semibold text-[#39766b]">75% ready</span>
            </div>
            <div class="divide-y divide-[#eeeae1]">
              <div v-for="(song, index) in songs" :key="song.title" class="flex items-center gap-4 px-5 py-4 sm:px-6">
                <span class="w-5 text-sm font-medium text-[#a5aaa4]">0{{ index + 1 }}</span>
                <span :class="['h-2.5 w-2.5 rounded-full', song.accent]" />
                <div class="min-w-0 flex-1">
                  <p class="truncate text-sm font-semibold">{{ song.title }}</p>
                  <p class="truncate text-xs text-[#78817c]">{{ song.artist }}</p>
                </div>
                <span class="hidden rounded-md bg-[#f3f1eb] px-2 py-1 text-xs font-semibold text-[#66716b] sm:inline">{{
                  song.key
                }}</span>
                <span
                  :class="song.status === 'Ready' ? 'text-[#39766b]' : 'text-[#b56e4b]'"
                  class="hidden text-xs font-medium md:inline"
                  >{{ song.status }}</span
                >
                <ChevronRight class="h-4 w-4 text-[#a5aaa4]" />
              </div>
            </div>
            <button
              class="flex w-full items-center justify-center gap-2 border-t border-[#e9e5db] px-5 py-3 text-sm font-semibold text-[#39766b] hover:bg-[#faf7f0] sm:hidden"
            >
              Open setlist <ArrowUpRight class="h-4 w-4" />
            </button>
          </div>
        </div>

        <aside class="rounded-2xl border border-[#dcd8ce] bg-[#fffdf8] p-6">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#b56e4b]">Rehearsal plan</p>
              <h2 class="mt-2 text-xl font-semibold">Next up</h2>
            </div>
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#e4f0e9] text-[#39766b]">
              <Clock3 class="h-5 w-5" />
            </div>
          </div>
          <div class="mt-7 space-y-6">
            <div class="flex gap-4">
              <div class="flex flex-col items-center">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#39766b] text-white"
                  ><Check class="h-4 w-4" /></span
                ><span class="mt-2 h-7 w-px bg-[#c9ddd5]" />
              </div>
              <div>
                <p class="text-sm font-semibold">Keys and rhythm section</p>
                <p class="mt-1 text-xs leading-5 text-[#78817c]">Tuesday · 7:00 PM<br />Sanctuary</p>
              </div>
            </div>
            <div class="flex gap-4">
              <div class="flex flex-col items-center">
                <span class="flex h-7 w-7 items-center justify-center rounded-full border-2 border-[#d8b79f] text-[#b56e4b]"
                  ><Circle class="h-3 w-3 fill-current"
                /></span>
              </div>
              <div>
                <p class="text-sm font-semibold">Full team run-through</p>
                <p class="mt-1 text-xs leading-5 text-[#78817c]">Thursday · 7:00 PM<br />Sanctuary</p>
              </div>
            </div>
          </div>
          <div class="mt-8 border-t border-[#e9e5db] pt-5">
            <p class="flex items-center gap-2 text-xs text-[#78817c]">
              <Users class="h-4 w-4 text-[#39766b]" /> 6 people have viewed this plan
            </p>
          </div>
        </aside>
      </section>

      <section class="mt-12 border-t border-[#dcd8ce] pt-8">
        <div class="flex flex-wrap items-end justify-between gap-4">
          <div>
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#b56e4b]">Keep creating</p>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight">Tools for the team</h2>
          </div>
          <p class="max-w-md text-sm leading-6 text-[#78817c]">
            The rest of your Sunday workflow is taking shape. Start with the tools already available today.
          </p>
        </div>
        <div class="mt-6 grid gap-4 sm:grid-cols-2">
          <Link
            href="/pianochords"
            class="group flex items-center justify-between rounded-2xl border border-[#dcd8ce] bg-[#fffdf8] p-5 transition hover:-translate-y-0.5 hover:border-[#a7c9be] hover:shadow-lg hover:shadow-[#39766b]/10"
            ><div class="flex items-center gap-4">
              <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#e4f0e9] text-[#39766b]">
                <ListMusic class="h-5 w-5" />
              </div>
              <div>
                <h3 class="font-semibold">Piano Chords</h3>
                <p class="mt-1 text-xs text-[#78817c]">Explore chords, scales, and progressions.</p>
              </div>
            </div>
            <ArrowUpRight class="h-5 w-5 text-[#a5aaa4] transition group-hover:text-[#39766b]"
          /></Link>
          <div class="flex items-center justify-between rounded-2xl border border-dashed border-[#c9c4b8] bg-[#f2f0e9] p-5">
            <div class="flex items-center gap-4">
              <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#e7ded2] text-[#a8876e]">
                <CalendarDays class="h-5 w-5" />
              </div>
              <div>
                <h3 class="font-semibold">Service calendar</h3>
                <p class="mt-1 text-xs text-[#78817c]">Coming next: plan your services.</p>
              </div>
            </div>
            <span class="text-[10px] font-semibold uppercase tracking-[0.14em] text-[#a8876e]">Soon</span>
          </div>
        </div>
      </section>
    </div>
  </main>
</template>
