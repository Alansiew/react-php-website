import { useContext } from "react";
import { AppContext } from "./Context";
import React from "react";
import "./index.css"
import {Card, Col} from 'antd';
import Container from "react-bootstrap/Container";

export const ProductList = () => {
    const {
        products,
        productLength,
        handleCheckbox,
    } = useContext(AppContext);

    return !productLength ? (
        <p>{productLength === null ? "Loading..." : "Please insert some products."}</p>
    ) : (
        <div className="square2" style={{alignItems: 'flex-end',flexDirection: 'row', flexWrap: 'wrap',marginLeft:"2%", }}>
            {products.map((product) =>
                <Container key={product.ID}>
                    <Card className="square"
                    >
                    <input className="delete-checkbox"
                           id ='.delete-checkbox'
                        type="checkbox"
                        value={product.ID}
                        checked={product.isChecked}
                        onChange={(e)=>handleCheckbox(e)}
                    ></input>
                        <Card >
                            <div> {product.SKU}</div>
                             <div> {product.NAME}</div>
                           <div> {`$${product.PRICE}`}</div>
                           <div> {product.Size ? `Size: ${product.Size} MB` : ''}</div>
                            <div> {product.Weight ? `Weight: ${product.Weight} KG` : ''}</div>
                            <div> {product.height ? `Dimension: ${product.height}x` : ''}
                             {product.width ? `${product.width}x` : ''}
                            {product.length ? `${product.length} CM` : ''}</div>
                        </Card>
                    </Card>
                </Container>
                )}
        </div>
    );

};