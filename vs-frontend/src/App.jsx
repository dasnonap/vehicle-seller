import { Outlet } from "react-router-dom"
import Footer from "./fragments/Footer"
import Header from "./fragments/Header"

function App() {
  return (
    <>
      <Header />
        <Outlet />
      <Footer />
    </>
  )
}

export default App
