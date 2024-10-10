import { observer } from "mobx-react"
import userStore from "../stores/userStore";

const Home = observer(() => {
    
    if(userStore.loadingUser){
        return 'loading...';
    }

    const user = userStore.getCurrentUser();

    console.log(user);
    return (
        <h2 className="">
            Hello again, {user.first_name}, {user.roles[0]}
        </h2>        
    )
});

export default Home;