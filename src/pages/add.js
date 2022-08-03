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
    //swicher type function
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
        <form id="product_form" className="product_form" onSubmit={submitProduct}>
            <h2>Insert User</h2>
            <label htmlFor="sku">SKU</label>

            <input
                type="text"
                id="sku"
                onChange={(e) => addNewProduct(e, "sku")}
                placeholder="Enter SKU"
                autoComplete="off"
                required
            />
            <label htmlFor="name">Name</label>
            <input
                type="name"
                id="name"
                onChange={(e) =>  addNewProduct(e, "name")}
                placeholder="Enter name"
                autoComplete="off"
                required
            />
            <label htmlFor="price">Price ($)</label>
            <input
                type="number"
                id="price"
                onChange={(e) =>  addNewProduct(e, "price")}
                placeholder="Enter price"
                autoComplete="off"
                required
            />
            <p>Type Switcher <select id="productType" className="productType" value={type} onChange={(e) => {addNewProduct(e, "type");handleChange(e)}} >
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
                        <p> <p htmlFor="size">Size (MB)</p>
                            <input
                                type="number"
                                id="size"
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
                    <p> <p htmlFor="height">Dimensions  (CM)</p>
                        <input
                            type="number"
                            id="height"
                            onChange={(e) => addNewProduct(e, "height")}
                            placeholder="Enter height"
                            autoComplete="off"
                            required
                        />
                        <input
                            type="number"
                            id="width"
                            onChange={(e) => addNewProduct(e, "width")}
                            placeholder="Enter width"
                            autoComplete="off"
                            required
                        />
                        <input
                            type="number"
                            id="length"
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
                    <p> <p htmlFor="weight">Weight (kg)</p>
                        <input
                            type="number"
                            id="weight"
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
