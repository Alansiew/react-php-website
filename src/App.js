import { Provider } from "./Context";
import { Actions } from "./Actions";
import React from 'react';
import './App.css';
import { BrowserRouter as Router, Routes, Route}
    from 'react-router-dom';
import Home from './index';
import Add from "./pages/add";

const App = () => {
    const data = Actions();
    return (
        <div>
            <Provider value={data}>
            <Router>
                <Routes>
                    <Route path="/" element={<Home/>} />
                    <Route path="/ProductAdd" element={<Add />} />
                </Routes>
            </Router>

            </Provider>

        </div>
    );
};
export default App;






