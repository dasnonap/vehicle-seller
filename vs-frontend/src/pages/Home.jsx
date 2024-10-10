import { observer } from "mobx-react"
import userStore from "../stores/userStore";

const Home = observer(() => {
    return (
        <h2>
            Hello again, {userStore.getCurrentUser().first_name}
        </h2>        
    )
});

export default Home;