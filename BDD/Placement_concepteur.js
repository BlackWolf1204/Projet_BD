
// Sauvegarder la position d'elements dans le concepteur de phpMyAdmin
tables = Array.from(document.querySelectorAll('.pmd_tab'))
console.log('[' + tables.map(t => `{nom: "${t.id}", left: "${t.style.left}", top: "${t.style.top}"}`).join(',\n') + ']')


// Restaurer la position d'elements dans le concepteur de phpMyAdmin
pos = [{ nom: "maisoneco.administrateur", left: "844px", top: "128px" },
{ nom: "maisoneco.appareil", left: "516px", top: "580px" },
{ nom: "maisoneco.appartement", left: "519px", top: "342px" },
{ nom: "maisoneco.consommer", left: "1058px", top: "552px" },
{ nom: "maisoneco.historiqueconsommation", left: "258px", top: "691px" },
{ nom: "maisoneco.immeuble", left: "847px", top: "313px" },
{ nom: "maisoneco.infopersonne", left: "534px", top: "28px" },
{ nom: "maisoneco.locataire", left: "613px", top: "206px" },
{ nom: "maisoneco.piece", left: "233px", top: "300px" },
{ nom: "maisoneco.produire", left: "1075px", top: "671px" },
{ nom: "maisoneco.proprietaire", left: "1041px", top: "228px" },
{ nom: "maisoneco.typeappareil", left: "760px", top: "612px" },
{ nom: "maisoneco.typeappartement", left: "401px", top: "490px" },
{ nom: "maisoneco.typepiece", left: "219px", top: "401px" },
{ nom: "maisoneco.typeressource", left: "1279px", top: "537px" },
{ nom: "maisoneco.typesecurite", left: "641px", top: "484px" },
{ nom: "maisoneco.typesubstance", left: "1285px", top: "673px" },
{ nom: "maisoneco.utilisateur", left: "850px", top: "7px" }];

tables = Array.from(document.querySelectorAll('.pmd_tab'))
tables.forEach(t => {
	p = pos.find(p => p.nom == t.id);
	if (!p) console.log('Pas de position pour ' + t.id);
	t.style.left = p.left;
	t.style.top = p.top;
});
Re_load();