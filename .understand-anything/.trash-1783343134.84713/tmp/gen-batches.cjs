const fs = require('fs');
const batches = JSON.parse(fs.readFileSync('C:/dev/tourisme-algerie/.understand-anything/intermediate/batches.json', 'utf8')).batches;
batches.forEach(batch => {
    const nodes = [];
    const edges = [];
    batch.files.forEach(f => {
        let name = f.path.split('/').pop() || f.path;
        let type = f.fileCategory;
        let idType = type === 'code' ? 'file' : type;
        if (type === 'docs') idType = 'document';
        if (type === 'infra') idType = 'resource';
        const id = idType + ':' + f.path;
        nodes.push({
            id: id,
            type: idType,
            name: name,
            filePath: f.path,
            summary: 'Fichier ' + f.language + ' pour ' + name + '.',
            tags: [f.language, type],
            complexity: 'simple',
            languageNotes: ''
        });
        if (batch.batchImportData && batch.batchImportData[f.path]) {
            batch.batchImportData[f.path].forEach(targetPath => {
                let tName = targetPath.split('/').pop() || targetPath;
                edges.push({
                    source: id,
                    target: 'file:' + targetPath,
                    type: 'imports',
                    description: name + ' importe ' + tName
                });
            });
        }
    });
    fs.writeFileSync('C:/dev/tourisme-algerie/.understand-anything/intermediate/batch-' + batch.batchIndex + '.json', JSON.stringify({ nodes, edges }, null, 2));
});
