<script setup lang="ts">
  import { Link } from "@inertiajs/vue3";
  import { House, Music, Piano } from "@lucide/vue";
</script>

<template>
  <header class="sticky top-0 z-20 border-b border-[#2d5c56] bg-[#173d3a] backdrop-blur">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center gap-4 px-4 py-3 sm:px-6 lg:px-8">
      <div class="flex shrink-0 gap-3">
        <div class="flex h-10 w-10 justify-center rounded-xl bg-[#e7b08c] p-2 text-[#173d3a]"><Music class="h-6 w-6" /></div>
        <div class="text-nowrap">
          <h1 class="text-xl font-bold text-[#f7f3e9]">SongGroup <span class="text-xs text-[#e7b08c]">APP</span></h1>
          <p class="text-xs text-[#a9c2ba]">The sound of Sunday</p>
        </div>
      </div>
      <div class="flex w-full min-w-0 justify-start sm:flex-1 sm:justify-center">
        <nav class="flex max-w-full gap-1 overflow-x-auto rounded-xl border border-[#47736b] bg-[#123330] p-1">
          <Link
            href="/"
            class="flex items-center gap-2 whitespace-nowrap rounded-lg px-3 py-2 text-sm transition"
            :class="
              $page.url === '/'
                ? 'bg-[#e7b08c] font-semibold text-[#173d3a]'
                : 'text-[#b8cec6] hover:bg-[#24504a] hover:text-[#f7f3e9]'
            "
          >
            <House class="h-4 w-4" />Home
          </Link>
          <Link
            href="/pianochords"
            class="flex items-center gap-2 whitespace-nowrap rounded-lg px-3 py-2 text-sm transition"
            :class="
              $page.url.startsWith('/pianochords')
                ? 'bg-[#e7b08c] font-semibold text-[#173d3a]'
                : 'text-[#b8cec6] hover:bg-[#24504a] hover:text-[#f7f3e9]'
            "
          >
            <Piano class="h-4 w-4" />Piano Chords
          </Link>
        </nav>
      </div>
    </div>
  </header>
</template>
