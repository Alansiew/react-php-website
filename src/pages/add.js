import { useState, useContext,useEffect } from "react";
import { AppContext } from "../Context";
import {Actions} from "../Actions";
import React from "react";
import { useNavigate} from 'react-router-dom';

export const  Add = () => {
    const data = Actions();
    const { insertProduct } = useContext(AppContext);
    const [newProduct, setNewProduct] = useState({});
    const [type, setType] = useState("selectType");
    const navigate = useNavigate();

    // Storing the Insert User Form Data.
    const addNewProduct = (e, field) => {
        setNewProduct({
            ...newProduct,
            [field]: e.target.value,

        });
    };
    const handleChange = e => {
        setType(e.target.value)

    };
    // Inserting a new user into the Database.
    useEffect(() => {
        type === "DVD"
            ? setDVDContentVisible(true)
            : setDVDContentVisible(false);
        type === "Furniture" ? setFurnitureContentVisible(true) : setFurnitureContentVisible(false);
        type === "Book" ? setBookContentVisible(true) : setBookContentVisible(false);
    }, [type]);

    const submitProduct = (e) => {
        e.preventDefault();
        insertProduct(newProduct);
        e.target.reset();

    };
    const [DVDContentVisible, setDVDContentVisible] = useState(false);
    const [FurnitureContentVisible, setFurnitureContentVisible] = useState(false);
    const [BookContentVisible, setBookContentVisible] = useState(false);


    return (
        <form className="insertForm" onSubmit={submitProduct}>
            <h2>Insert User</h2>
            <label htmlFor="_sku">SKU</label>

            <input
                type="text"
                id="_sku"
                onChange={(e) => addNewProduct(e, "sku")}
                placeholder="Enter SKU"
                autoComplete="off"
                required
            />
            <label htmlFor="_name">Name</label>
            <input
                type="name"
                id="_name"
                onChange={(e) =>  addNewProduct(e, "name")}
                placeholder="Enter name"
                autoComplete="off"
                required
            />
            <label htmlFor="_price">Price ($)</label>
            <input
                type="number"
                id="_price"
                onChange={(e) =>  addNewProduct(e, "price")}
                placeholder="Enter price"
                autoComplete="off"
                required
            />
            <p>Type Switcher <select className="form-select" value={type} onChange={(e) => {addNewProduct(e, "type");handleChange(e)}} >
                <option value="select type of product">-- Select Type --</option>
                <option  value="DVD" >DVD </option>
                <option value="Furniture">Furniture</option>
                <option value="Book">Book</option>

            </select>

            </p>
            {DVDContentVisible &&
                <div className="mt-4">
                    <div className="fs-3">

                        <strong>DVD </strong>
                        <p> <p htmlFor="_size">Size (MB)</p>
                            <input
                                type="number"
                                id="_size"
                                onChange={(e) => addNewProduct(e, "size")}
                                placeholder="Enter size"
                                autoComplete="off"
                                required
                            />
                            <label>
                                Product Description...
                            </label>
                        </p>
                    </div>


                </div>}
            {FurnitureContentVisible && <div className="mt-4">
                <div className="fs-3">

                    <strong>Furniture </strong>
                    <p> <p htmlFor="_height">Dimensions  (CM)</p>
                        <input
                            type="number"
                            id="_height"
                            onChange={(e) => addNewProduct(e, "height")}
                            placeholder="Enter height"
                            autoComplete="off"
                            required
                        />
                        <input
                            type="number"
                            id="_width"
                            onChange={(e) => addNewProduct(e, "width")}
                            placeholder="Enter width"
                            autoComplete="off"
                            required
                        />
                        <input
                            type="number"
                            id="_length"
                            onChange={(e) => addNewProduct(e, "length")}
                            placeholder="Enter length"
                            autoComplete="off"
                            required
                        />
                        <label>
                            Product Description...
                        </label>
                    </p>
                </div>


            </div>}
            {BookContentVisible &&
                <div className="mt-4">
                <div className="fs-3">

                    <strong>BOOK </strong>
                    <p> <p htmlFor="_weight">Weight (kg)</p>
                        <input
                            type="number"
                            id="_weight"
                            onChange={(e) => addNewProduct(e, "weight")}
                            placeholder="Enter weight"
                            autoComplete="off"
                            required
                        />
                        <p>
                            <label> Product Description... </label>
                        </p>
                    </p>
                </div>


            </div>}

            <input type="submit" value="Save" />
            <input  type="Cancel" onClick={() => navigate(window.location.href="/")} value="Cancel"/>
        </form>


    );

};

export default Add;
