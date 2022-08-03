import { useEffect, useState } from "react";
import axios from "axios";

export const Actions = () => {
    let [products, setProduct] = useState([]);

    //productLength is for showing the Data Loading message.
    let [productLength, setProductLength] = useState(null);
    const [isChecked,setIsChecked]=useState([]);
    const [delmsg, setDelMsg]= useState('');
    useEffect(() => {
        fetch("http://alan-siewiera.epizy.com/untitled1/php-react/all_products.php")
            .then((res) => {
                return res.json();
            })
            .then((data) => {
                if (data.success) {
                    setProduct(data.products.reverse());
                    setProductLength(true);
                } else {
                    setProductLength(0);
                }
            })
            .catch((err) => {
                console.log(err);
            });
    }, []);

    // Inserting a new product into the database.
    const insertProduct = (newProduct) => {
        fetch("http://alan-siewiera.epizy.com/untitled1/php-react/add_product.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(newProduct),
        })
            .then((res) => {
                return res.json();
            })
            .then((data) => {
                if (data.id) {
                    setProduct([
                        {
                            id: data.id,
                            ...newProduct,
                        },
                        ...products,
                    ]);
                    setProductLength(true);
                } else {
                    alert(data.msg);
                }
            })
            .catch((err) => {
                console.log(err);
            });
    };

    const handleCheckbox =(e)=>{
        const {value,checked} = e.target;
        if(checked){
            setIsChecked([...isChecked,value]);
        }else {
            setIsChecked(isChecked.filter((e)=>e!==value ));
        }
    }
    //delete product from the database
    const deleteProduct= async()=>{
        //console.log(isChecked);
        if(isChecked.length!==0){
            const responce= await axios.post(`http://alan-siewiera.epizy.com/untitled1/php-react/delete_product.php`, JSON.stringify(isChecked));
            setDelMsg(responce.data.msg);
            setTimeout( ()=>{
            }, 2000);
            window.location.reload(false);
        } else {
            alert("please Select at least one check box !");
        }

    }
    return {
        products,
        insertProduct,
        productLength,
        handleCheckbox,
        deleteProduct,
    };
};