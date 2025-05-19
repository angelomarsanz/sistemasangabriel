import { React, StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import { useState } from 'react';

export const IndexProveedores = () => { 
  const [count, setCount] = useState(0)

  return (
    <>
      <h1>Vite + React</h1>
      <div className="card">
        <button onClick={() => setCount((count) => count + 1)}>
          El contador es {count}
        </button>
      </div>
    </>
  )
}

let indexProveedores = document.getElementById('indexProveedores');

if (indexProveedores != null) 
{
  const root = createRoot(indexProveedores);

  root.render(
    <StrictMode>
      <IndexProveedores />
    </StrictMode>
    );
}