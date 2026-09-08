<script setup lang="ts">
  import { computed, onBeforeUnmount, ref, watch } from "vue";
  import { Head } from "@inertiajs/vue3";
  import ChordExplorer from "./ChordExplorer.vue";
  import EarTrainingQuiz from "./EarTrainingQuiz.vue";
  import PianoKeyboard from "./PianoKeyboard.vue";
  import ProgressionBuilder from "./ProgressionBuilder.vue";
  import ScaleExplorer from "./ScaleExplorer.vue";
  import type { ChordDefinition } from "./types";
  import {
    BookOpen,
    GraduationCap,
    Layers,
    ListMusic,
    Music,
    Music2,
    Play,
    RotateCcw,
    Search,
    Volume2,
    VolumeX,
  } from "@lucide/vue";

  type Tab = "explorer" | "identifier" | "scales" | "progressions" | "quiz";
  type SoundPreset = "piano" | "epiano" | "synth";
  type PlayStyle = "chord" | "strum" | "arpeggio";
  type AccidentalMode = "sharps" | "flats" | "custom";
  const NOTE_NAMES_SHARP = ["C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B"];
  const NOTE_NAMES_FLAT = ["C", "Db", "D", "Eb", "E", "F", "Gb", "G", "Ab", "A", "Bb", "B"];
  const BLACK_KEYS = [1, 3, 6, 8, 10];
  const CHORD_DEFINITIONS: ChordDefinition[] = [
    {
      id: "maj",
      name: "Major",
      abbr: "",
      formula: [0, 4, 7],
      intervals: ["1", "3", "5"],
      category: "Triads",
      fingerings: { RH: "1-3-5", LH: "5-3-1" },
    },
    {
      id: "m",
      name: "Minor",
      abbr: "m",
      formula: [0, 3, 7],
      intervals: ["1", "b3", "5"],
      category: "Triads",
      fingerings: { RH: "1-3-5", LH: "5-3-1" },
    },
    {
      id: "dim",
      name: "Diminished",
      abbr: "dim",
      formula: [0, 3, 6],
      intervals: ["1", "b3", "b5"],
      category: "Triads",
      fingerings: { RH: "1-3-5", LH: "5-3-1" },
    },
    {
      id: "aug",
      name: "Augmented",
      abbr: "aug",
      formula: [0, 4, 8],
      intervals: ["1", "3", "#5"],
      category: "Triads",
      fingerings: { RH: "1-3-5", LH: "5-3-1" },
    },
    {
      id: "sus2",
      name: "Suspended 2nd",
      abbr: "sus2",
      formula: [0, 2, 7],
      intervals: ["1", "2", "5"],
      category: "Suspended",
      fingerings: { RH: "1-2-5", LH: "5-4-1" },
    },
    {
      id: "sus4",
      name: "Suspended 4th",
      abbr: "sus4",
      formula: [0, 5, 7],
      intervals: ["1", "4", "5"],
      category: "Suspended",
      fingerings: { RH: "1-4-5", LH: "5-2-1" },
    },
    {
      id: "7",
      name: "Dominant 7th",
      abbr: "7",
      formula: [0, 4, 7, 10],
      intervals: ["1", "3", "5", "b7"],
      category: "7ths",
      fingerings: { RH: "1-2-3-5", LH: "5-4-2-1" },
    },
    {
      id: "maj7",
      name: "Major 7th",
      abbr: "maj7",
      formula: [0, 4, 7, 11],
      intervals: ["1", "3", "5", "7"],
      category: "7ths",
      fingerings: { RH: "1-2-3-5", LH: "5-4-2-1" },
    },
    {
      id: "m7",
      name: "Minor 7th",
      abbr: "m7",
      formula: [0, 3, 7, 10],
      intervals: ["1", "b3", "5", "b7"],
      category: "7ths",
      fingerings: { RH: "1-2-3-5", LH: "5-4-2-1" },
    },
    {
      id: "dim7",
      name: "Diminished 7th",
      abbr: "dim7",
      formula: [0, 3, 6, 9],
      intervals: ["1", "b3", "b5", "bb7"],
      category: "7ths",
      fingerings: { RH: "1-2-3-5", LH: "5-4-2-1" },
    },
    {
      id: "6",
      name: "Major 6th",
      abbr: "6",
      formula: [0, 4, 7, 9],
      intervals: ["1", "3", "5", "6"],
      category: "6ths",
      fingerings: { RH: "1-2-3-5", LH: "5-4-2-1" },
    },
    {
      id: "m6",
      name: "Minor 6th",
      abbr: "m6",
      formula: [0, 3, 7, 9],
      intervals: ["1", "b3", "5", "6"],
      category: "6ths",
      fingerings: { RH: "1-2-3-5", LH: "5-4-2-1" },
    },
    {
      id: "add9",
      name: "Add 9",
      abbr: "add9",
      formula: [0, 4, 7, 14],
      intervals: ["1", "3", "5", "9"],
      category: "Extended",
      fingerings: { RH: "1-2-3-5", LH: "5-4-2-1" },
    },
    {
      id: "m9",
      name: "Minor 9th",
      abbr: "m9",
      formula: [0, 3, 7, 10, 14],
      intervals: ["1", "b3", "5", "b7", "9"],
      category: "Extended",
      fingerings: { RH: "1-2-3-4-5", LH: "5-4-3-2-1" },
    },
    {
      id: "9",
      name: "Dominant 9th",
      abbr: "9",
      formula: [0, 4, 7, 10, 14],
      intervals: ["1", "3", "5", "b7", "9"],
      category: "Extended",
      fingerings: { RH: "1-2-3-4-5", LH: "5-4-3-2-1" },
    },
  ];
  const SCALES = [
    { id: "major", name: "Major (Ionian)", pattern: [0, 2, 4, 5, 7, 9, 11] },
    { id: "minor", name: "Natural Minor (Aeolian)", pattern: [0, 2, 3, 5, 7, 8, 10] },
    { id: "harmonic_minor", name: "Harmonic Minor", pattern: [0, 2, 3, 5, 7, 8, 11] },
    { id: "dorian", name: "Dorian", pattern: [0, 2, 3, 5, 7, 9, 10] },
    { id: "pentatonic_maj", name: "Major Pentatonic", pattern: [0, 2, 4, 7, 9] },
  ];
  const POPULAR_PROGRESSIONS = [
    {
      name: "Pop Anthem (I - V - vi - IV)",
      chords: [
        { r: 0, t: "maj" },
        { r: 7, t: "maj" },
        { r: 9, t: "m" },
        { r: 5, t: "maj" },
      ],
    },
    {
      name: "Jazz Standard (ii - V - I - VI)",
      chords: [
        { r: 2, t: "m7" },
        { r: 7, t: "7" },
        { r: 0, t: "maj7" },
        { r: 9, t: "7" },
      ],
    },
    {
      name: "Classic Blues (I - IV - I - V)",
      chords: [
        { r: 0, t: "7" },
        { r: 5, t: "7" },
        { r: 0, t: "7" },
        { r: 7, t: "7" },
      ],
    },
    {
      name: "Emotional Ballad (vi - IV - I - V)",
      chords: [
        { r: 9, t: "m" },
        { r: 5, t: "maj" },
        { r: 0, t: "maj" },
        { r: 7, t: "maj" },
      ],
    },
  ];

  const activeTab = ref<Tab>("explorer");
  const rootNote = ref(0);
  const chordType = ref("maj");
  const accidentalMode = ref<AccidentalMode>("sharps");
  const customAccidentals = ref<Record<number, "sharp" | "flat">>({
    1: "sharp",
    3: "sharp",
    6: "sharp",
    8: "sharp",
    10: "sharp",
  });
  const setMode = ref(false);
  const inversion = ref(0);
  const octave = ref(4);
  const slashBass = ref<number | null>(null);
  const volume = ref(0.8);
  const muted = ref(false);
  const soundPreset = ref<SoundPreset>("piano");
  const playStyle = ref<PlayStyle>("chord");
  const tempo = ref(110);
  const manualNotes = ref<number[]>([]);
  const scaleRoot = ref(0);
  const selectedScale = ref("major");
  const selectedProgression = ref(POPULAR_PROGRESSIONS[0]);
  const progressionStep = ref(0);
  const playingProgression = ref(false);
  const quizScore = ref(0);
  const quizTotal = ref(0);
  const quizCurrent = ref<{ root: number; def: ChordDefinition } | null>(null);
  const quizOptions = ref<{ root: number; def: ChordDefinition }[]>([]);
  const quizAnswered = ref<{ option: { root: number; def: ChordDefinition }; correct: boolean } | null>(null);
  let audioContext: AudioContext | null = null;
  let progressionTimer: ReturnType<typeof setTimeout> | undefined;

  const currentChord = computed(() => CHORD_DEFINITIONS.find((chord) => chord.id === chordType.value) ?? CHORD_DEFINITIONS[0]);
  const currentScale = computed(() => SCALES.find((scale) => scale.id === selectedScale.value) ?? SCALES[0]);
  const noteName = (pitch: number): string => {
    const normalized = ((pitch % 12) + 12) % 12;
    if (accidentalMode.value === "flats" || (accidentalMode.value === "custom" && customAccidentals.value[normalized] === "flat"))
      return NOTE_NAMES_FLAT[normalized];
    return NOTE_NAMES_SHARP[normalized];
  };
  const toggleAccidental = (pitch: number) => {
    const normalized = ((pitch % 12) + 12) % 12;
    if (BLACK_KEYS.includes(normalized))
      customAccidentals.value[normalized] = customAccidentals.value[normalized] === "flat" ? "sharp" : "flat";
  };
  const calculatedNotes = computed(() => {
    const notes = currentChord.value.formula.map((offset) => octave.value * 12 + rootNote.value + offset);
    for (let index = 0; index < inversion.value % notes.length; index++) notes.push(notes.shift()! + 12);
    return slashBass.value === null ? notes : [(octave.value - 1) * 12 + slashBass.value, ...notes];
  });
  const scaleNotes = computed(() => currentScale.value.pattern.map((offset) => 60 + scaleRoot.value + offset));
  const activeNotes = computed(() =>
    activeTab.value === "explorer"
      ? calculatedNotes.value
      : activeTab.value === "identifier"
        ? manualNotes.value
        : activeTab.value === "scales"
          ? scaleNotes.value
          : activeTab.value === "quiz" && quizAnswered.value && quizCurrent.value
            ? quizCurrent.value.def.formula.map((offset) => 60 + quizCurrent.value!.root + offset)
            : [],
  );
  const identifiedChords = computed(() => {
    const pitches = [...new Set(manualNotes.value.map((note) => ((note % 12) + 12) % 12))].sort((a, b) => a - b);
    if (!pitches.length) return [];
    const bass = ((manualNotes.value[0] % 12) + 12) % 12;
    return CHORD_DEFINITIONS.flatMap((def) =>
      Array.from({ length: 12 }, (_, root) => {
        const chordPitches = def.formula.map((offset) => (root + offset) % 12);
        if (pitches.length !== chordPitches.length || !pitches.every((pitch) => chordPitches.includes(pitch))) return null;
        const slash = root !== bass ? `/${noteName(bass)}` : "";
        return {
          root,
          def,
          shortName: `${noteName(root)}${def.abbr}${slash}`,
          fullName: `${noteName(root)} ${def.name}${slash}`,
        };
      }).filter(Boolean),
    ).filter((match): match is { root: number; def: ChordDefinition; shortName: string; fullName: string } => match !== null);
  });
  const getAudioContext = () => {
    if (!audioContext) audioContext = new AudioContext();
    if (audioContext.state === "suspended") void audioContext.resume();
    return audioContext;
  };
  const midiToFrequency = (midi: number) => 440 * Math.pow(2, (midi - 69) / 12);
  const playNote = (midi: number, duration = 1.5, delay = 0) => {
    if (muted.value) return;
    const context = getAudioContext();
    const now = context.currentTime + delay;
    const oscillator = context.createOscillator();
    const gain = context.createGain();
    oscillator.type = soundPreset.value === "synth" ? "sawtooth" : soundPreset.value === "epiano" ? "sine" : "triangle";
    oscillator.frequency.value = midiToFrequency(midi);
    gain.gain.setValueAtTime(0.001, now);
    gain.gain.exponentialRampToValueAtTime(volume.value, now + 0.02);
    gain.gain.exponentialRampToValueAtTime(0.001, now + duration);
    oscillator.connect(gain).connect(context.destination);
    oscillator.start(now);
    oscillator.stop(now + duration + 0.05);
  };
  const playChord = (notes = calculatedNotes.value) =>
    notes.forEach((note, index) =>
      playNote(
        note,
        playStyle.value === "arpeggio" ? 1.2 : 2,
        playStyle.value === "chord" ? 0 : index * (playStyle.value === "strum" ? 0.06 : 0.22),
      ),
    );
  const handleKey = (midi: number) => {
    playNote(midi, 1.2);
    if (activeTab.value === "identifier")
      manualNotes.value = manualNotes.value.includes(midi)
        ? manualNotes.value.filter((note) => note !== midi)
        : [...manualNotes.value, midi];
  };
  const startQuiz = () => {
    const correct = {
      root: Math.floor(Math.random() * 12),
      def: CHORD_DEFINITIONS[Math.floor(Math.random() * CHORD_DEFINITIONS.length)],
    };
    const options = [correct];
    while (options.length < 4) {
      const option = {
        root: Math.floor(Math.random() * 12),
        def: CHORD_DEFINITIONS[Math.floor(Math.random() * CHORD_DEFINITIONS.length)],
      };
      if (!options.some((item) => item.root === option.root && item.def.id === option.def.id)) options.push(option);
    }
    quizCurrent.value = correct;
    quizOptions.value = options.sort(() => Math.random() - 0.5);
    quizAnswered.value = null;
    setTimeout(() => playChord(correct.def.formula.map((offset) => 60 + correct.root + offset)), 300);
  };
  const answerQuiz = (option: { root: number; def: ChordDefinition }) => {
    if (!quizCurrent.value || quizAnswered.value) return;
    const correct = option.root === quizCurrent.value.root && option.def.id === quizCurrent.value.def.id;
    quizAnswered.value = { option, correct };
    quizTotal.value++;
    if (correct) quizScore.value++;
  };
  const selectTab = (tab: Tab) => {
    activeTab.value = tab;
    if (tab === "quiz" && !quizCurrent.value) startQuiz();
  };
  watch([playingProgression, progressionStep, tempo], () => {
    clearTimeout(progressionTimer);
    if (!playingProgression.value) return;
    const chord = selectedProgression.value.chords[progressionStep.value];
    const definition = CHORD_DEFINITIONS.find((item) => item.id === chord.t) ?? CHORD_DEFINITIONS[0];
    playChord(definition.formula.map((offset) => 60 + chord.r + offset));
    progressionTimer = setTimeout(
      () => {
        progressionStep.value = (progressionStep.value + 1) % selectedProgression.value.chords.length;
      },
      (60 / tempo.value) * 2000,
    );
  });
  onBeforeUnmount(() => clearTimeout(progressionTimer));
  const intervalTag = (midi: number) => {
    if (activeTab.value !== "explorer") return "";
    const index = currentChord.value.formula.findIndex(
      (offset) => offset % 12 === (midi - octave.value * 12 - rootNote.value + 1200) % 12,
    );
    return index >= 0 ? currentChord.value.intervals[index] : "";
  };
</script>

<template>
  <Head title="PianoChord Studio" />
  <div class="min-h-screen bg-slate-950 text-slate-100 antialiased">
    <header class="sticky top-0 z-20 border-b border-slate-800 bg-slate-900/95 backdrop-blur">
      <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-4 py-3">
        <div class="flex items-center gap-3">
          <div class="rounded-xl bg-indigo-600 p-2"><Music class="h-6 w-6" /></div>
          <div>
            <h1 class="text-xl font-bold">PianoChord <span class="text-xs text-indigo-300">MODULE</span></h1>
            <p class="text-xs text-slate-400">Interactive theory workbench</p>
          </div>
        </div>
        <nav class="flex gap-1 overflow-x-auto rounded-xl border border-slate-800 bg-slate-950 p-1">
          <button
            v-for="item in [
              { id: 'explorer', label: 'Explorer', icon: BookOpen },
              { id: 'identifier', label: 'Finder', icon: Search },
              { id: 'scales', label: 'Scales', icon: Layers },
              { id: 'progressions', label: 'Progressions', icon: ListMusic },
              { id: 'quiz', label: 'Quiz', icon: GraduationCap },
            ]"
            :key="item.id"
            class="flex items-center gap-2 whitespace-nowrap rounded-lg px-3 py-2 text-sm"
            :class="activeTab === item.id ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800'"
            @click="selectTab(item.id as Tab)"
          >
            <component :is="item.icon" class="h-4 w-4" />{{ item.label }}
          </button>
        </nav>
        <div class="flex items-center gap-2">
          <select v-model="soundPreset" class="rounded-lg border border-slate-800 bg-slate-900 px-2 py-2 text-xs">
            <option value="piano">Grand Piano</option>
            <option value="epiano">Electric Piano</option>
            <option value="synth">Warm Synth</option></select
          ><button
            class="rounded-lg border border-slate-800 bg-slate-900 p-2"
            :aria-label="muted ? 'Unmute audio' : 'Mute audio'"
            @click="muted = !muted"
          >
            <VolumeX v-if="muted" class="h-4 w-4 text-rose-400" /><Volume2 v-else class="h-4 w-4" />
          </button>
        </div>
      </div>
    </header>
    <main class="mx-auto flex w-full max-w-7xl flex-col gap-6 p-4 md:p-6">
      <section class="rounded-2xl border border-slate-800 bg-slate-900 p-4 shadow-xl md:p-6">
        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
          <h2 class="text-lg font-semibold">
            <span class="mr-2 inline-block h-3 w-3 rounded-full bg-emerald-500" />{{
              activeTab === "explorer"
                ? `${noteName(rootNote)}${currentChord.abbr} keyboard`
                : activeTab === "identifier"
                  ? "Click notes to identify a chord"
                  : activeTab === "scales"
                    ? `${noteName(scaleRoot)} ${currentScale.name}`
                    : activeTab === "progressions"
                      ? selectedProgression.name
                      : "Interactive piano test"
            }}
          </h2>
          <div class="flex flex-wrap gap-2">
            <select v-model="accidentalMode" class="rounded-lg border border-slate-700 bg-slate-800 px-2 py-2 text-xs">
              <option value="sharps">♯ Sharps</option>
              <option value="flats">♭ Flats</option>
              <option value="custom">Custom</option></select
            ><button
              v-if="accidentalMode === 'custom'"
              class="rounded-lg bg-slate-800 px-2 py-2 text-xs"
              @click="setMode = !setMode"
            >
              Set: {{ setMode ? "ON" : "OFF" }}</button
            ><button
              class="flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium hover:bg-indigo-500"
              @click="playChord()"
            >
              <Play class="h-4 w-4 fill-current" />Play</button
            ><select v-model="playStyle" class="rounded-xl border border-slate-700 bg-slate-800 px-3 py-2 text-xs">
              <option value="chord">Block Chord</option>
              <option value="strum">Strum</option>
              <option value="arpeggio">Arpeggio</option>
            </select>
          </div>
        </div>
        <PianoKeyboard
          :active-notes="activeNotes"
          :root-note-midi="activeTab === 'explorer' ? octave * 12 + rootNote : null"
          :note-name="noteName"
          :interval-tag="intervalTag"
          :accidental-mode="accidentalMode"
          :set-mode="setMode"
          @key-click="handleKey"
          @toggle-accidental="toggleAccidental"
        />
      </section>
      <ChordExplorer
        v-if="activeTab === 'explorer'"
        :root-note="rootNote"
        :chord-type="chordType"
        :inversion="inversion"
        :slash-bass="slashBass"
        :note-name="noteName"
        :current-chord="currentChord"
        :chord-definitions="CHORD_DEFINITIONS"
        :calculated-notes="calculatedNotes"
        @root-change="
          (root) => {
            rootNote = root;
            slashBass = null;
          }
        "
        @chord-type-change="(type) => (chordType = type)"
        @inversion-change="(position) => (inversion = position)"
        @slash-bass-change="(bass) => (slashBass = bass)"
        @play="playChord()"
      />
      <section v-else-if="activeTab === 'identifier'" class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6 lg:col-span-2">
          <div class="mb-4 flex items-center justify-between">
            <h3 class="flex items-center gap-2 text-lg font-bold"><Search class="h-5 w-5 text-indigo-400" />Chord matches</h3>
            <button class="flex items-center gap-2 rounded-lg bg-slate-800 px-3 py-2 text-xs" @click="manualNotes = []">
              <RotateCcw class="h-4 w-4" />Clear
            </button>
          </div>
          <div class="mb-6 rounded-xl border border-slate-800 bg-slate-950 p-4 text-sm">
            <span class="text-slate-400">Selected: </span
            ><span v-if="!manualNotes.length" class="text-slate-500">click keys above</span
            ><span
              v-for="note in manualNotes"
              v-else
              :key="note"
              class="mr-2 rounded bg-indigo-600 px-2 py-1 text-xs font-bold"
              >{{ noteName(note) }}</span
            >
          </div>
          <div
            v-if="!identifiedChords.length"
            class="rounded-xl border border-dashed border-slate-800 py-12 text-center text-sm text-slate-500"
          >
            <Music2 class="mx-auto mb-2 h-10 w-10 opacity-40" />Select notes to identify a chord.
          </div>
          <div
            v-for="match in identifiedChords"
            v-else
            :key="match.shortName"
            class="mb-3 flex items-center justify-between rounded-xl border border-slate-800 bg-slate-950 p-4"
          >
            <div>
              <strong class="text-lg text-indigo-300">{{ match.shortName }}</strong>
              <p class="text-xs text-slate-400">{{ match.fullName }} · {{ match.def.intervals.join(" - ") }}</p>
            </div>
            <button
              class="rounded-lg border border-indigo-500/30 px-3 py-2 text-xs text-indigo-300"
              @click="
                rootNote = match.root;
                chordType = match.def.id;
                selectTab('explorer');
              "
            >
              Explore
            </button>
          </div>
        </div>
        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6 text-sm text-slate-400">
          <h4 class="mb-3 font-semibold text-slate-200">Reverse finder</h4>
          <p>Build a chord on the keyboard and PianoChord will compare its pitch classes against the library.</p>
        </div>
      </section>
      <ScaleExplorer
        v-else-if="activeTab === 'scales'"
        :scale-root="scaleRoot"
        :selected-scale="selectedScale"
        :current-scale="currentScale"
        :scales="SCALES"
        :note-name="noteName"
        @scale-root-change="(root) => (scaleRoot = root)"
        @scale-change="(scale) => (selectedScale = scale)"
        @explore-chord="
          (root, type) => {
            rootNote = root;
            chordType = type;
            selectTab('explorer');
          }
        "
      />
      <ProgressionBuilder
        v-else-if="activeTab === 'progressions'"
        :progressions="POPULAR_PROGRESSIONS"
        :selected-progression="selectedProgression"
        :chord-definitions="CHORD_DEFINITIONS"
        :progression-step="progressionStep"
        :playing="playingProgression"
        :tempo="tempo"
        :note-name="noteName"
        @select="
          (progression) => {
            selectedProgression = progression;
            progressionStep = 0;
            playingProgression = false;
          }
        "
        @toggle="playingProgression = !playingProgression"
        @tempo-change="(value) => (tempo = value)"
      />
      <EarTrainingQuiz
        v-else
        :score="quizScore"
        :total="quizTotal"
        :current="quizCurrent"
        :options="quizOptions"
        :answered="quizAnswered"
        :note-name="noteName"
        @replay="quizCurrent && playChord(quizCurrent.def.formula.map((offset) => 60 + quizCurrent!.root + offset))"
        @answer="answerQuiz"
        @next="startQuiz"
      />
    </main>
    <footer class="border-t border-slate-800 py-6 text-center text-xs text-slate-500">
      PianoChord Module · Web Audio API music theory reference
    </footer>
  </div>
</template>
