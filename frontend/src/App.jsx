import { useState } from "react";
import reactLogo from "./assets/react.svg";
import viteLogo from "/vite.svg";
import "./App.css";
import "bootstrap/dist/css/bootstrap.min.css";
import { BrowserRouter, Routes, Route, Link } from "react-router-dom";
import Userlist from "./components/Userlist";
import Add from "./components/Add";
import Edit from "./components/Edit";

function App() {
  return (
    <div className="container">
      <h1 className="mt-5 mb-5 text-center">
        <b>
          FullStackReactPHP -{" "}
          <span className="text-primary">CRUD API Endpoints</span>
        </b>
      </h1>
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Userlist />} />
          <Route path="/add" element={<Add />} />
          <Route path="/edit/:user_id" element={<Edit />} />
        </Routes>
      </BrowserRouter>
    </div>
  );
}

export default App;
