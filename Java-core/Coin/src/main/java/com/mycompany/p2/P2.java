// Nội dung : Bài này sẽ cho trước giá cổ phiếu, nếu bạn mua vào ngày thứ a và bán vào ngày b thì sẽ lời c? 
// Nếu như không lời thì return 0
package com.mycompany.p2;

import java.util.ArrayList;
import java.lang.Math;
import java.util.Scanner;
public class P2 {

    ArrayList<Integer> prices = new ArrayList<>();

    public void prices() {
        for (int i = 0; i < 30; i++) {
            int data = (int)(Math.random() * 10000000 + 1);
            prices.add(data);
        }
        Scanner input = new Scanner(System.in);
        int dulieu = (int)(Math.random()* 30 + 1);
        System.out.println("Hom nay la ngay " + dulieu);
        for (int i = 1; i<= 30; i++) {
            if (dulieu == i) {
                System.out.println("gia co phieu hom nay la : " + prices.get(i) + " VND");
            }
        }
        dulieu = dulieu - 1;
        System.out.println("Ban co muon mua co phieu cua ngay hom nay khong?");
        String yesorno = input.nextLine();
        if (yesorno.equals("yes")){
            System.out.println("Chuc mung ban! Chuc ban thanh cong!");
            System.out.println("Ban muon ban co phieu vao ngay thu may cua thang?");
            int ban = input.nextInt();
            ban = ban - 1;
            int result = prices.get(dulieu) - prices.get(ban);
            if (result > 0) {
                System.out.println("Chuc mung ban! Ban se loi duoc: " + result + " VND");
            }
            else if (result == 0) {
                System.out.println("Ban se hoa von!");
            }
            else {
                System.out.println("Ban da thua lo " + Math.abs(result) + " VND");
            }
        }
        
        else {
            System.out.println("Hen gap lai!");
        }
    }
}
