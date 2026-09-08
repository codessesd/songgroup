export type ChordDefinition = {
  id: string;
  name: string;
  abbr: string;
  formula: number[];
  intervals: string[];
  category: string;
  fingerings: { RH: string; LH: string };
};

export type ChordMatch = {
  root: number;
  def: ChordDefinition;
  shortName: string;
  fullName: string;
};
