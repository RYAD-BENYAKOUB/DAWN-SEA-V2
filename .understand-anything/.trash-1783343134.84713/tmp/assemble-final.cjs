const fs = require('fs');
const stripBom = (str) => str.charCodeAt(0) === 0xFEFF ? str.slice(1) : str;
const scan = JSON.parse(stripBom(fs.readFileSync('C:/dev/tourisme-algerie/.understand-anything/intermediate/scan-result.json', 'utf8')));
const graph = JSON.parse(stripBom(fs.readFileSync('C:/dev/tourisme-algerie/.understand-anything/intermediate/assembled-graph.json', 'utf8')));
const layers = JSON.parse(stripBom(fs.readFileSync('C:/dev/tourisme-algerie/.understand-anything/intermediate/layers.json', 'utf8')));
const tour = JSON.parse(stripBom(fs.readFileSync('C:/dev/tourisme-algerie/.understand-anything/intermediate/tour.json', 'utf8')));
const finalGraph = {
  version: '1.0.0',
  project: {
    name: scan.name,
    languages: scan.languages || [],
    frameworks: scan.frameworks || [],
    description: scan.description || '',
    analyzedAt: new Date().toISOString(),
    gitCommitHash: '13ab49e64a20d47cda0a422dd0db7476ca332505'
  },
  nodes: graph.nodes || [],
  edges: graph.edges || [],
  layers: layers || [],
  tour: tour || []
};
fs.writeFileSync('C:/dev/tourisme-algerie/.understand-anything/intermediate/assembled-graph.json', JSON.stringify(finalGraph, null, 2));
