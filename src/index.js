import React from 'react';
import './index.css';
import App from './App';
import { useNavigate} from 'react-router-dom';
import ReactDOM from "react-dom";
import  {ProductList} from "./Product_List";
import {useContext} from "react";
import {AppContext} from "./Context";

const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(
    <React.StrictMode>
        <App />
    </React.StrictMode>
);

const Home = (props) => {
    const navigate = useNavigate();
    const {
        deleteProduct,
    } = useContext(AppContext);
    return (
        <>
            <div className='Home'>
                <p >
                    Product List
                    <button className="add-btn" onClick={() => navigate("/ProductAdd")}>Add</button>

                    <button  className="btn red-btn" onClick={deleteProduct}>Mass Delete</button>

                    <hr
                        style={{
                            background: 'black',
                            color: 'black',
                            borderColor: 'grey',
                            height: '1px',
                            borderWidth: 1,
                            marginRight: 200,
                        }}
                    />
                    <div className="App">
                        <ProductList />
                    </div>
                    <hr
                        style={{
                            background: 'black',
                            color: 'black',
                            borderColor: 'grey',
                            height: '1px',
                            borderWidth: 1,
                            marginRight: 200,
                        }}
                    />
                </p>
            </div>
        </>
    );
};
export default Home;