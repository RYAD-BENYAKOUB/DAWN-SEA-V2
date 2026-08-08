const fs = require('fs');
const stripBom = (str) => str.charCodeAt(0) === 0xFEFF ? str.slice(1) : str;
const scan = JSON.parse(stripBom(fs.readFileSync('C:/dev/tourisme-algerie/.understand-anything/intermediate/scan-result.json', 'utf8')));
const graph = JSON.parse(stripBom(fs.readFileSync('C:/dev/tourisme-algerie/.understand-anything/intermediate/assembled-graph.json', 'utf8')));
fs.writeFileSync('C:/dev/tourisme-algerie/.understand-anything/knowledge-graph.json', JSON.stringify(graph, null, 2));

const fingerprintInput = {
  projectRoot: 'C:/dev/tourisme-algerie',
  sourceFilePaths: scan.files.map(f => f.path),
  gitCommitHash: '13ab49e64a20d47cda0a422dd0db7476ca332505'
};
fs.writeFileSync('C:/dev/tourisme-algerie/.understand-anything/intermediate/fingerprint-input.json', JSON.stringify(fingerprintInput, null, 2));

const meta = {
  lastAnalyzedAt: new Date().toISOString(),
  gitCommitHash: '13ab49e64a20d47cda0a422dd0db7476ca332505',
  version: '1.0.0',
  analyzedFiles: scan.totalFiles
};
fs.writeFileSync('C:/dev/tourisme-algerie/.understand-anything/meta.json', JSON.stringify(meta, null, 2));
