$(() => {
  // initialize the Router component
  window.prestashop.component.initComponents(['Grid']);

  const grid = window.prestashop.instance.grid;
  const gridExtensions = window.prestashop.component.GridExtensions;

  for (extensionClass in gridExtensions) {
    gridExtension = window.prestashop.component.GridExtensions[extensionClass]
    grid.addExtension(new gridExtension())
  }
});
