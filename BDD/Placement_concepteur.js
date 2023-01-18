
// Sauvegarder la position d'elements dans le concepteur de phpMyAdmin
tables = Array.from(document.querySelectorAll('.pma-table'))
console.log('[' + tables.map(t => `{nom: "${t.id}", left: "${t.style.left}", top: "${t.style.top}"}`).join(',\n') + ']')


// Restaurer la position d'elements dans le concepteur de phpMyAdmin
pos = [{ nom: "maisoneco.administrateur", left: "1336px", top: "44px" },
{ nom: "maisoneco.adresse", left: "1050px", top: "440px" },
{ nom: "maisoneco.appareil", left: "196px", top: "671px" },
{ nom: "maisoneco.appartement", left: "524px", top: "382px" },
{ nom: "maisoneco.consommer", left: "927px", top: "658px" },
{ nom: "maisoneco.departement", left: "1366px", top: "323px" },
{ nom: "maisoneco.dernierlocataire", left: "170px", top: "470px" },
{ nom: "maisoneco.dernierproprietaire", left: "228px", top: "22px" },
{ nom: "maisoneco.historiqueconsommation", left: "183px", top: "832px" },
{ nom: "maisoneco.infopersonne", left: "1067px", top: "45px" },
{ nom: "maisoneco.locataire", left: "537px", top: "223px" },
{ nom: "maisoneco.locataireactuel", left: "210px", top: "46px" },
{ nom: "maisoneco.piece", left: "206px", top: "379px" },
{ nom: "maisoneco.produire", left: "929px", top: "816px" },
{ nom: "maisoneco.proprietaire", left: "837px", top: "228px" },
{ nom: "maisoneco.proprietaireactuel", left: "131px", top: "140px" },
{ nom: "maisoneco.propriete", left: "843px", top: "396px" },
{ nom: "maisoneco.proprieteadresse", left: "42px", top: "311px" },
{ nom: "maisoneco.region", left: "1175px", top: "337px" },
{ nom: "maisoneco.rue", left: "1237px", top: "438px" },
{ nom: "maisoneco.typeappareil", left: "666px", top: "773px" },
{ nom: "maisoneco.typeappartement", left: "511px", top: "615px" },
{ nom: "maisoneco.typepiece", left: "200px", top: "499px" },
{ nom: "maisoneco.typeressource", left: "1179px", top: "668px" },
{ nom: "maisoneco.typesecurite", left: "521px", top: "536px" },
{ nom: "maisoneco.typesubstance", left: "1173px", top: "824px" },
{ nom: "maisoneco.utilisateur", left: "646px", top: "31px" },
{ nom: "maisoneco.ville", left: "1404px", top: "428px" }];

tables = Array.from(document.querySelectorAll('.pma-table'))
tables.forEach(t => {
	p = pos.find(p => p.nom == t.id);
	if (!p) { console.log('Pas de position pour ' + t.id); return; }
	t.style.left = p.left;
	t.style.top = p.top;
});
