<script setup lang="ts">
  import { Head } from "@inertiajs/vue3";
  import { CalendarDays, Check, ChevronRight, Circle, Clock3, ListMusic, Plus, Users } from "@lucide/vue";

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
      <h1 class="max-w-2xl text-4xl font-semibold leading-[1.05] tracking-tight sm:text-6xl">An App for every Sunday</h1>
      <p class="text-xs font-semibold uppercase mt-8 tracking-[0.18em] text-[#b56e4b]">
        Nothing here yet! Something special is coming...
      </p>

      <section class="hidden mt-12 pt-8">
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
          <div class="flex items-center justify-between rounded-2xl border border-[#dcd8ce] bg-[#fffdf8] p-5">
            <div class="flex items-center gap-4">
              <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#e4f0e9] text-[#39766b]">
                <ListMusic class="h-5 w-5" />
              </div>
              <div>
                <h3 class="font-semibold">Piano Chords</h3>
                <p class="mt-1 text-xs text-[#78817c]">Explore chords, scales, and progressions.</p>
              </div>
            </div>
            <span class="text-[10px] font-semibold uppercase tracking-[0.14em] text-[#a8876e]">Preview</span>
          </div>
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
