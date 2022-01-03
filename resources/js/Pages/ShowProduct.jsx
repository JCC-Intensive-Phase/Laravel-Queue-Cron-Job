import React,{useState, useEffect} from 'react'
import { Head, Link } from '@inertiajs/inertia-react'
import Navbar from '../components/Navbar'
import axios from 'axios'



const ShowProduct = ({auth}) =>{
    const [data,setData] = useState([])
    useEffect(() => {
        axios.get(`/api/product`)
            .then(data=>setData(data.data.data))
            .catch(error=>console.log(error))
        return () => {
            setData([])
        }
    }, [])
    return(
        <>
            <Navbar auth={auth}/>
            <div className='container mt-5  '>
                <h1>Semua Produk</h1>
                <table className="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga Produk</th>
                            <th scope="col">Gambar Original</th>
                            <th scope="col">Gambar Small</th>
                            <th scope="col">Gambar Medium</th>
                            <th scope="col">Gambar Large</th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.map((data,index)=>{
                            return(
                                <tr key={data.id}>
                                    <th scope="row">{index+1}</th>
                                    <td>{data.product_name}</td>
                                    <td>{data.product_price}</td>
                                    <td>
                                        <img
                                            src={data.original_image_url}
                                            className='img-thumbnail'
                                            style={{width:'200px'}}
                                            />
                                    </td>
                                    <td>
                                        <img
                                            src={data.small_image_url}
                                            className='img-thumbnail'
                                            style={{width:'200px'}}
                                            />
                                    </td>
                                    <td>
                                        <img
                                            src={data.medium_image_url}
                                            className='img-thumbnail'
                                            style={{width:'200px'}}
                                            />
                                    </td>
                                    <td>
                                        <img
                                            src={data.large_image_url}
                                            className='img-thumbnail'
                                            style={{width:'200px'}}
                                            />
                                    </td>
                                </tr>

                            )
                        })}
                    </tbody>
                </table>
            </div>
        </>
    )
}
export default ShowProduct
