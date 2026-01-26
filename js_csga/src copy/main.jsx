import 'vite/modulepreload-polyfill'
import './index.css';
import { indexBills } from './vistas/Bills';
import { indexUsers, addUsers } from './vistas/Users';
import { ReactProveedors } from './vistas/Proveedors';
import { consultaDeudaRepresentante } from './vistas/Studenttransactions';
import { servicioEducativo } from './vistas/Studenttransactions';
import { reporteFormasDePago } from './vistas/Students';
import { indexCuentasPorCobrar } from './vistas/CuentasPorCobrar';

console.log('Hola desde main.js');