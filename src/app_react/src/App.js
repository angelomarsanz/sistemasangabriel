import "./App.css";

function MyButton() {
  return (
    <button>
      Soy un botón
    </button>
  );
}

export default function MyApp() {
  return (
    <div>
      <h1>Bienvenido a mi aplicación react "app_react" reubicada, renombrada y super automatizada con node 18.20</h1>
      <p>Dios me da la sabiduría para entender React</p>
      <MyButton />
    </div>
  );
}