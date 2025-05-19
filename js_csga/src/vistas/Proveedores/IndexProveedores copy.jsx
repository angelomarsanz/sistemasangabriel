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
          count is {count}
        </button>
      </div>
    </>
  )
}

let rootElement = document.getElementById('indexProveedores');

if (rootElement != null) 
{
  const root = createRoot(rootElement);

  root.render(
    <StrictMode>
      <IndexProveedores />
    </StrictMode>
    );
}