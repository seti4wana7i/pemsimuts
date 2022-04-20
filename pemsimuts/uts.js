class reglinear{
    b0;
    b1;
    constructor(x,y){
        this.x = x;
        this.y = y;
    }

    preCount(){
        //jumlah x
        let sum_x = this.x.reduce(function (previousValue, currentValue){
            return previousValue + currentValue
        }, 0)

        //jumlah y
        let sum_y = this.y.reduce(function (previousValue, currentValue){
            return previousValue + currentValue
        }, 0)

        //x^2
        let x_kuadrat = this.x.map(x => x**2);
        //y^2
        let y_kuadrat = this.y.map(x => x**2);

        //x.y
        let x_y = this.x.map((x,i) => x * this.y[i]);

        //jumlah x^2
        let sum_x_kuadrat = x_kuadrat.reduce((a, b) => a + b, 0);
        //jumlah y^2
        let sum_y_kuadrat = y_kuadrat.reduce((a, b) => a + b, 0);
        //jumlah x.y
        let sum_x_y = x_y.reduce((a, b) => a + b, 0);

        let lx = this.x.length;

        //intercept
        this.b0 = (sum_y*sum_x_kuadrat - sum_x*sum_x_y) / (lx*sum_x_kuadrat - sum_x ** 2);
        let b0_ref = this.b0;
        //coefficient
        this.b1 = (lx*sum_x_y - sum_x*sum_y) / (lx*sum_x_kuadrat - sum_x**2);
        let b1_ref = this.b1;

        
        let r = (lx*sum_x_y - sum_x*sum_y)/(Math.sqrt((lx*sum_x_kuadrat - sum_x**2)*(lx*sum_y_kuadrat - sum_y**2)));

        let kd = (r**2)*100;

        return {sum_x, sum_y, x_kuadrat, y_kuadrat, x_y, sum_x_kuadrat, sum_y_kuadrat, sum_x_y, b0_ref, b1_ref, r, kd};
    }

    predict_y(x1){
        return this.b0 + this.b1 * x1;
    }

}

export {reglinear};