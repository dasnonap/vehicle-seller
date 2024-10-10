import { observer } from "mobx-react"
import userStore from "../stores/userStore";

const Home = observer(() => {
    
    if(userStore.loadingUser){
        return 'loading...';
    }

    const user = userStore.getCurrentUser();


    return (
        <h2>
            Hello again, {user.first_name}
        </h2>        
    )
});

export default Home;