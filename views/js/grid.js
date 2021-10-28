$(() => {
  // initialize the Grid Component
  window.prestashop.component.initComponents(['Grid']);

  const grid = window.prestashop.instance.grid;
  grid.id = grid_id;
  const gridExtensions = window.prestashop.component.GridExtensions;

  for (extensionClass in gridExtensions) {
    gridExtension = window.prestashop.component.GridExtensions[extensionClass]
    grid.addExtension(new gridExtension())
  }
});
