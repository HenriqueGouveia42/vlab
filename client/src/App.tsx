import { BrowserRouter, Routes, Route, useNavigate } from 'react-router-dom';
import Dashboard from './components/Dashboard';
import './App.css';

function TelaBemVindo() {
  const navigate = useNavigate();
  return (
    <div className="welcome-screen">
      <h1>Bem vindo ao sistema de lançamento de solicitações</h1>
      <p>Gerencie suas solicitações de forma rápida e eficiente.</p>
      <button className="btn-entrar" onClick={() => navigate('/app')}>
        Acessar o Sistema
      </button>
    </div>
  );
}

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<TelaBemVindo />} />
        <Route path="/app/*" element={<Dashboard />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;