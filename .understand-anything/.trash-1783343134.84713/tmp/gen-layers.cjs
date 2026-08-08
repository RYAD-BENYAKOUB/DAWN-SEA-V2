const fs = require('fs');
const graph = JSON.parse(fs.readFileSync('C:/dev/tourisme-algerie/.understand-anything/intermediate/assembled-graph.json', 'utf8'));
const layersMap = {
    'Controllers': { id: 'layer:controllers', description: 'Gère les requêtes HTTP', nodeIds: [] },
    'Models': { id: 'layer:models', description: 'Entités de domaine et accès base de données', nodeIds: [] },
    'Views': { id: 'layer:views', description: 'Composants de présentation', nodeIds: [] },
    'Routes': { id: 'layer:routes', description: 'Définitions des endpoints', nodeIds: [] },
    'Database': { id: 'layer:database', description: 'Migrations, seeders et usines', nodeIds: [] },
    'Config': { id: 'layer:config', description: 'Fichiers de configuration', nodeIds: [] },
    'Frontend': { id: 'layer:frontend', description: 'Assets JS/CSS et ressources publiques', nodeIds: [] },
    'Core': { id: 'layer:core', description: 'Logique métier, services et fournisseurs', nodeIds: [] },
    'Documentation': { id: 'layer:docs', description: 'Fichiers de documentation', nodeIds: [] },
    'Other': { id: 'layer:other', description: 'Autres fichiers', nodeIds: [] }
};
graph.nodes.forEach(n => {
    let path = n.filePath || '';
    if (path.startsWith('app/Http/Controllers')) layersMap['Controllers'].nodeIds.push(n.id);
    else if (path.startsWith('app/Models')) layersMap['Models'].nodeIds.push(n.id);
    else if (path.startsWith('resources/views') || path.startsWith('app/View')) layersMap['Views'].nodeIds.push(n.id);
    else if (path.startsWith('routes/')) layersMap['Routes'].nodeIds.push(n.id);
    else if (path.startsWith('database/')) layersMap['Database'].nodeIds.push(n.id);
    else if (path.startsWith('config/') || path.endsWith('.json') || path.endsWith('.env')) layersMap['Config'].nodeIds.push(n.id);
    else if (path.startsWith('public/') || path.startsWith('resources/js') || path.startsWith('resources/css') || path.endsWith('.js') || path.endsWith('.css')) layersMap['Frontend'].nodeIds.push(n.id);
    else if (path.startsWith('app/')) layersMap['Core'].nodeIds.push(n.id);
    else if (path.endsWith('.md')) layersMap['Documentation'].nodeIds.push(n.id);
    else layersMap['Other'].nodeIds.push(n.id);
});
const layers = Object.keys(layersMap).map(k => ({ name: k, ...layersMap[k] })).filter(l => l.nodeIds.length > 0);
fs.writeFileSync('C:/dev/tourisme-algerie/.understand-anything/intermediate/layers.json', JSON.stringify(layers, null, 2));
