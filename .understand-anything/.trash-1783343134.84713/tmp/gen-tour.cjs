const fs = require('fs');
const graph = JSON.parse(fs.readFileSync('C:/dev/tourisme-algerie/.understand-anything/intermediate/assembled-graph.json', 'utf8'));
const nodeIds = new Set(graph.nodes.map(n => n.id));
function getValid(ids) { return ids.filter(id => nodeIds.has(id)); }
const tour = [
    { order: 1, title: 'Présentation du projet', description: 'Démarrez par le fichier README pour comprendre le but et l\'architecture du projet.', nodeIds: getValid(['document:README.md']) },
    { order: 2, title: 'Configuration et Point d\'entrée', description: 'Fichiers de bootstrap et de configuration de l\'application Laravel.', nodeIds: getValid(['file:bootstrap/app.php', 'config:composer.json', 'config:package.json']) },
    { order: 3, title: 'Routage', description: 'Définition des endpoints HTTP.', nodeIds: getValid(['file:routes/web.php', 'file:routes/api.php', 'file:routes/auth.php']) },
    { order: 4, title: 'Modèles de données', description: 'Les entités principales et leurs relations avec la base de données.', nodeIds: getValid(['file:app/Models/User.php', 'file:app/Models/Program.php', 'file:app/Models/Visit.php']) }
].filter(s => s.nodeIds.length > 0);
fs.writeFileSync('C:/dev/tourisme-algerie/.understand-anything/intermediate/tour.json', JSON.stringify(tour, null, 2));
