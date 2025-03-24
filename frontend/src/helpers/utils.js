export function generateNroFactura() {
  const date = new Date();
  const components = [
    date.getFullYear().toString().substr(-2),
    date.getMonth() + 1,
    date.getDate(),
    date.getHours(),
    date.getMinutes(),
    date.getSeconds(),
  ];
  const paddedComponents = components.map((component) =>
    component.toString().padStart(2, "0")
  );
  return "F" + paddedComponents.join("");
}
